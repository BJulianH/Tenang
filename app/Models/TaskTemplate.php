<?php
// app/Models/TaskTemplate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category',
        'estimated_duration',
        'energy_level_required',
        'difficulty_level',
        'priority',
        'is_important',
        'is_urgent',
        'tags',
        'is_public',
        'usage_count',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_public' => 'boolean',
        'is_important' => 'boolean',
        'is_urgent' => 'boolean',
        'estimated_duration' => 'integer',
        'energy_level_required' => 'integer',
        'difficulty_level' => 'integer',
    ];

    protected $appends = [
        'category_name',
        'duration_hours',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Tasks yang dibuat dari template ini
    public function tasks()
    {
        return $this->hasMany(Task::class, 'template_id');
    }

    // Scope untuk template publik
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Scope untuk template user tertentu
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId)
                    ->orWhere('is_public', true);
    }

    // Accessor untuk nama kategori
    public function getCategoryNameAttribute()
    {
        $categories = [
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
            'other' => 'Lainnya',
        ];
        
        return $categories[$this->category] ?? 'Lainnya';
    }

    // Accessor untuk durasi
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

    // Create task from template
    public function createTask($userId, $dueDate = null, $dueTime = null)
    {
        $task = Task::create([
            'user_id' => $userId,
            'title' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'priority' => $this->priority,
            'estimated_duration' => $this->estimated_duration,
            'energy_level_required' => $this->energy_level_required,
            'difficulty_level' => $this->difficulty_level,
            'is_important' => $this->is_important,
            'is_urgent' => $this->is_urgent,
            'tags' => $this->tags,
            'due_date' => $dueDate,
            'due_time' => $dueTime,
            'template_id' => $this->id,
        ]);

        $this->increment('usage_count');

        return $task;
    }
}