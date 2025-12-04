<?php
// app/Models/Task.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'category',
        'status',
        'due_date',
        'due_time',
        'reminder_before',
        'is_recurring',
        'recurring_pattern',
        'recurring_days',
        'recurring_end_date',
        'estimated_duration',
        'energy_level_required',
        'difficulty_level',
        'is_important',
        'is_urgent',
        'completed_at',
        'mood_before',
        'mood_after',
        'notes',
        'tags',
        'streak_count',
        'completion_count',
        'parent_id', // untuk subtasks
    ];

    protected $casts = [
        'due_date' => 'date',
        'due_time' => 'datetime:H:i',
        'is_recurring' => 'boolean',
        'is_important' => 'boolean',
        'is_urgent' => 'boolean',
        'completed_at' => 'datetime',
        'recurring_days' => 'array',
        'tags' => 'array',
        'recurring_end_date' => 'date',
        'energy_level_required' => 'integer',
        'difficulty_level' => 'integer',
        'mood_before' => 'integer',
        'mood_after' => 'integer',
    ];

    protected $appends = [
        'is_overdue',
        'is_due_today',
        'is_due_soon',
        'full_due_datetime',
        'priority_color',
        'category_icon',
        'category_name',
        'human_due_date',
        'duration_hours',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Reminders
    public function reminders()
    {
        return $this->hasMany(TaskReminder::class);
    }

    // Relasi ke Completion History
    public function completions()
    {
        return $this->hasMany(TaskCompletion::class);
    }

    // Subtasks (hierarchical tasks)
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    // Relasi ke Template (jika dibuat dari template)
    public function template()
    {
        return $this->belongsTo(TaskTemplate::class, 'template_id');
    }

    // SCOPES

    // Scope untuk user tertentu
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope untuk tugas aktif (belum selesai/dibatalkan)
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['completed', 'cancelled']);
    }

    // Scope untuk tugas hari ini
    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', Carbon::today());
    }

    // Scope untuk tugas besok
    public function scopeDueTomorrow($query)
    {
        return $query->whereDate('due_date', Carbon::tomorrow());
    }

    // Scope untuk tugas minggu ini
    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [
            Carbon::today(),
            Carbon::today()->endOfWeek()
        ]);
    }

    // Scope untuk tugas overdue
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', Carbon::today())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    // Scope berdasarkan kategori
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope berdasarkan priority
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    // Scope untuk tugas penting
    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    // Scope untuk tugas mendesak
    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    // Scope Eisenhower Matrix
    public function scopeImportantUrgent($query)
    {
        return $query->where('is_important', true)->where('is_urgent', true);
    }

    public function scopeImportantNotUrgent($query)
    {
        return $query->where('is_important', true)->where('is_urgent', false);
    }

    public function scopeNotImportantUrgent($query)
    {
        return $query->where('is_important', false)->where('is_urgent', true);
    }

    public function scopeNotImportantNotUrgent($query)
    {
        return $query->where('is_important', false)->where('is_urgent', false);
    }

    // ACCESSORS

    public function getIsOverdueAttribute()
    {
        if (!$this->due_date || in_array($this->status, ['completed', 'cancelled'])) {
            return false;
        }
        
        return Carbon::parse($this->due_date)->isPast();
    }

    public function getIsDueTodayAttribute()
    {
        if (!$this->due_date) {
            return false;
        }
        
        return Carbon::parse($this->due_date)->isToday();
    }

    public function getIsDueSoonAttribute()
    {
        if (!$this->due_date || $this->is_overdue || $this->is_due_today) {
            return false;
        }
        
        return Carbon::parse($this->due_date)->isBetween(
            Carbon::today(),
            Carbon::today()->addDays(2)
        );
    }

    public function getFullDueDatetimeAttribute()
    {
        if (!$this->due_date) {
            return null;
        }
        
        $datetime = Carbon::parse($this->due_date);
        
        if ($this->due_time) {
            $time = Carbon::parse($this->due_time);
            $datetime->setTime($time->hour, $time->minute);
        }
        
        return $datetime;
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'urgent' => '#dc2626', // red-600
            'high' => '#ea580c',   // orange-600
            'medium' => '#2563eb',  // blue-600
            'low' => '#16a34a',    // green-600
            default => '#6b7280',   // gray-500
        };
    }

    public function getCategoryIconAttribute()
    {
        return match($this->category) {
            'self_care' => '🛁',
            'therapy' => '🧠',
            'medication' => '💊',
            'exercise' => '🏃‍♂️',
            'social' => '👥',
            'work' => '💼',
            'appointment' => '📅',
            'mindfulness' => '🧘‍♂️',
            'creative' => '🎨',
            'chores' => '🧹',
            'study' => '📚',
            'meal' => '🍽️',
            'shopping' => '🛒',
            'family' => '👨‍👩‍👧‍👦',
            'finance' => '💰',
            'hobby' => '🎮',
            'sleep' => '😴',
            'hygiene' => '🚿',
            default => '📝',
        };
    }

    public function getCategoryNameAttribute()
    {
        return match($this->category) {
            'self_care' => 'Perawatan Diri',
            'therapy' => 'Terapi',
            'medication' => 'Obat-obatan',
            'exercise' => 'Olahraga',
            'social' => 'Sosial',
            'work' => 'Pekerjaan',
            'appointment' => 'Janji Temu',
            'mindfulness' => 'Mindfulness',
            'creative' => 'Kreatif',
            'chores' => 'Pekerjaan Rumah',
            'study' => 'Belajar',
            'meal' => 'Makan',
            'shopping' => 'Belanja',
            'family' => 'Keluarga',
            'finance' => 'Keuangan',
            'hobby' => 'Hobi',
            'sleep' => 'Tidur',
            'hygiene' => 'Kebersihan',
            default => 'Lainnya',
        };
    }

    public function getHumanDueDateAttribute()
    {
        if (!$this->due_date) {
            return 'Tanpa tanggal';
        }
        
        $date = Carbon::parse($this->due_date);
        
        if ($date->isToday()) {
            return 'Hari ini' . ($this->due_time ? ' ' . $this->due_time->format('H:i') : '');
        }
        
        if ($date->isTomorrow()) {
            return 'Besok' . ($this->due_time ? ' ' . $this->due_time->format('H:i') : '');
        }
        
        if ($date->isYesterday()) {
            return 'Kemarin' . ($this->due_time ? ' ' . $this->due_time->format('H:i') : '');
        }
        
        return $date->translatedFormat('d M Y') . ($this->due_time ? ' ' . $this->due_time->format('H:i') : '');
    }

    public function getDurationHoursAttribute()
    {
        if (!$this->estimated_duration) {
            return null;
        }
        
        if ($this->estimated_duration < 60) {
            return $this->estimated_duration . ' menit';
        }
        
        $hours = floor($this->estimated_duration / 60);
        $minutes = $this->estimated_duration % 60;
        
        if ($minutes === 0) {
            return $hours . ' jam';
        }
        
        return $hours . ' jam ' . $minutes . ' menit';
    }

    // METHODS

    // Tandai task sebagai selesai
    public function markAsCompleted($moodBefore = null, $moodAfter = null, $notes = null, $actualDuration = null)
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'mood_before' => $moodBefore,
            'mood_after' => $moodAfter,
            'notes' => $notes,
            'streak_count' => $this->streak_count + 1,
            'completion_count' => $this->completion_count + 1,
        ]);

        // Catat di history
        $taskCompletion = TaskCompletion::create([
            'task_id' => $this->id,
            'user_id' => $this->user_id,
            'completed_at' => now(),
            'mood_before' => $moodBefore,
            'mood_after' => $moodAfter,
            'notes' => $notes,
            'actual_duration' => $actualDuration,
            'points_earned' => $this->calculatePoints(),
        ]);

        // Update user stats
        $this->user->increment('tasks_completed');
        $this->user->update([
            'last_task_completed_at' => now(),
            'task_streak' => $this->updateUserTaskStreak(),
        ]);

        // Beri reward points
        $points = $this->calculatePoints();
        $this->user->addPoints($points);
        
        // Tambah coins jika mood membaik
        if ($moodAfter && $moodBefore && $moodAfter > $moodBefore) {
            $this->user->addCoins(5);
        }

        // Generate next recurring task jika ada
        if ($this->is_recurring && (!$this->recurring_end_date || now()->lt($this->recurring_end_date))) {
            $this->generateNextRecurringTask();
        }

        return [
            'task' => $this->fresh(),
            'points_earned' => $points,
            'completion' => $taskCompletion,
        ];
    }

    // Tandai task sebagai in progress
    public function markAsInProgress()
    {
        $this->update([
            'status' => 'in_progress',
        ]);
        
        return $this;
    }

    // Snooze task
    public function snooze($minutes = 30)
    {
        $newTime = now()->addMinutes($minutes);
        
        $this->update([
            'status' => 'snoozed',
            'due_time' => $newTime->format('H:i'),
        ]);
        
        return $this;
    }

    // Update mood before task
    public function updateMoodBefore($mood)
    {
        $this->update(['mood_before' => $mood]);
        return $this;
    }

    // Update mood after task
    public function updateMoodAfter($mood)
    {
        $this->update(['mood_after' => $mood]);
        return $this;
    }

    // Hitung points yang didapat
    private function calculatePoints()
    {
        $points = 10; // Base points
        
        // Bonus berdasarkan priority
        $points += match($this->priority) {
            'urgent' => 20,
            'high' => 15,
            'medium' => 10,
            'low' => 5,
            default => 0,
        };

        // Bonus untuk difficulty
        if ($this->difficulty_level) {
            $points += $this->difficulty_level * 5;
        }

        // Bonus untuk tugas penting
        if ($this->is_important) {
            $points += 10;
        }

        // Bonus untuk tugas mendesak
        if ($this->is_urgent) {
            $points += 5;
        }

        // Bonus streak
        if ($this->streak_count > 0) {
            $points += min($this->streak_count * 2, 20); // Max 20 bonus points
        }

        return $points;
    }

    // Update user task streak
    private function updateUserTaskStreak()
    {
        $user = $this->user;
        $lastCompletion = $user->last_task_completed_at;
        
        if (!$lastCompletion) {
            return 1;
        }
        
        $yesterday = now()->subDay()->startOfDay();
        $lastCompletionDate = $lastCompletion->startOfDay();
        
        if ($lastCompletionDate->isToday()) {
            return $user->task_streak;
        }
        
        if ($lastCompletionDate->equalTo($yesterday)) {
            return $user->task_streak + 1;
        }
        
        return 1;
    }

    // Generate next recurring task
    public function generateNextRecurringTask()
    {
        if (!$this->is_recurring) {
            return null;
        }

        $nextDate = $this->calculateNextRecurrence();

        if (!$nextDate || ($this->recurring_end_date && $nextDate > $this->recurring_end_date)) {
            return null;
        }

        $nextTask = Task::create([
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'category' => $this->category,
            'due_date' => $nextDate,
            'due_time' => $this->due_time,
            'is_recurring' => true,
            'recurring_pattern' => $this->recurring_pattern,
            'recurring_days' => $this->recurring_days,
            'recurring_end_date' => $this->recurring_end_date,
            'estimated_duration' => $this->estimated_duration,
            'energy_level_required' => $this->energy_level_required,
            'difficulty_level' => $this->difficulty_level,
            'is_important' => $this->is_important,
            'is_urgent' => $this->is_urgent,
            'tags' => $this->tags,
            'parent_id' => $this->parent_id,
            'streak_count' => 0,
            'completion_count' => 0,
        ]);

        return $nextTask;
    }

    private function calculateNextRecurrence()
    {
        $baseDate = Carbon::parse($this->due_date ?? now());

        return match($this->recurring_pattern) {
            'daily' => $baseDate->addDay(),
            'weekly' => $baseDate->addWeek(),
            'monthly' => $baseDate->addMonth(),
            'weekdays' => $this->getNextWeekday($baseDate),
            'weekends' => $this->getNextWeekendDay($baseDate),
            'custom' => $this->getNextCustomDay($baseDate),
            default => null,
        };
    }

    private function getNextWeekday($date)
    {
        $nextDate = $date->copy()->addDay();
        
        while ($nextDate->isWeekend()) {
            $nextDate->addDay();
        }
        
        return $nextDate;
    }

    private function getNextWeekendDay($date)
    {
        $nextDate = $date->copy()->addDay();
        
        while (!$nextDate->isWeekend()) {
            $nextDate->addDay();
        }
        
        return $nextDate;
    }

    private function getNextCustomDay($date)
    {
        if (empty($this->recurring_days)) {
            return null;
        }
        
        $nextDate = $date->copy()->addDay();
        
        while (!in_array($nextDate->dayOfWeek, $this->recurring_days)) {
            $nextDate->addDay();
            
            // Prevent infinite loop
            if ($nextDate->diffInDays($date) > 30) {
                return null;
            }
        }
        
        return $nextDate;
    }

    // Cek apakah task bisa diselesaikan (semua subtask selesai)
    public function canBeCompleted()
    {
        if ($this->subtasks()->count() === 0) {
            return true;
        }
        
        return $this->subtasks()->where('status', '!=', 'completed')->count() === 0;
    }

    // Get completion rate
    public function getCompletionRate()
    {
        if ($this->completion_count === 0) {
            return 0;
        }
        
        $totalOccurrences = $this->created_at->diffInDays(now()) + 1;
        return round(($this->completion_count / $totalOccurrences) * 100, 2);
    }

    // Get mood improvement
    public function getMoodImprovement()
    {
        if (!$this->mood_before || !$this->mood_after) {
            return 0;
        }
        
        return $this->mood_after - $this->mood_before;
    }
}