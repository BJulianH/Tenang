<?php
// app/Models/TaskCompletion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'completed_at',
        'mood_before',
        'mood_after',
        'actual_duration',
        'notes',
        'points_earned',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'mood_before' => 'integer',
        'mood_after' => 'integer',
    ];

    protected $appends = [
        'mood_improvement',
        'completion_date',
    ];

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk mood improvement
    public function getMoodImprovementAttribute()
    {
        if (!$this->mood_before || !$this->mood_after) {
            return null;
        }
        
        return $this->mood_after - $this->mood_before;
    }

    // Accessor untuk tanggal penyelesaian
    public function getCompletionDateAttribute()
    {
        return $this->completed_at->format('Y-m-d');
    }

    // Scope untuk rentang tanggal
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('completed_at', [$startDate, $endDate]);
    }

    // Scope untuk mood tertentu
    public function scopeWithMoodImprovement($query, $minImprovement = 0)
    {
        return $query->whereNotNull('mood_before')
                    ->whereNotNull('mood_after')
                    ->whereRaw('mood_after - mood_before >= ?', [$minImprovement]);
    }
}