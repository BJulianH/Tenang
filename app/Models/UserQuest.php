<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'daily_quest_id',
        'status',
        'progress',
        'required_progress',
        'assigned_date',
        'completed_at',
        'claimed_at'
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'completed_at' => 'datetime',
        'claimed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyQuest()
    {
        return $this->belongsTo(DailyQuest::class);
    }

    // Scope for today's quests
    public function scopeForToday($query)
    {
        return $query->where('assigned_date', today());
    }

    // Scope for completed quests
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')->orWhere('status', 'claimed');
    }

    // Scope for active quests
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['assigned', 'in_progress']);
    }

    // Check if quest is completed
    public function isCompleted()
    {
        return $this->progress >= $this->required_progress;
    }

    // Mark as in progress
    public function markInProgress()
    {
        $this->update(['status' => 'in_progress']);
    }

    // Mark as completed
    public function markCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress' => $this->required_progress
        ]);
    }

    // Mark as claimed
    public function markClaimed()
    {
        $this->update([
            'status' => 'claimed',
            'claimed_at' => now()
        ]);
    }

    // Update progress
    public function updateProgress($progress)
    {
        $this->update(['progress' => $progress]);
        
        if ($this->isCompleted()) {
            $this->markCompleted();
        } else {
            $this->markInProgress();
        }
    }

    // Add progress
    public function addProgress($amount = 1)
    {
        $newProgress = min($this->progress + $amount, $this->required_progress);
        $this->updateProgress($newProgress);
    }

    // Calculate completion percentage
    public function getCompletionPercentageAttribute()
    {
        return ($this->progress / $this->required_progress) * 100;
    }
}