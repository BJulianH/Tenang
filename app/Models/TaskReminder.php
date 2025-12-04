<?php
// app/Models/TaskReminder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'reminder_time',
        'status',
        'channel',
        'message',
        'sent_at',
    ];

    protected $casts = [
        'reminder_time' => 'datetime',
        'sent_at' => 'datetime',
    ];

    protected $appends = [
        'human_reminder_time',
    ];

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Scope untuk reminders yang belum dikirim
    public function scopePending($query)
    {
        return $query->where('status', 'pending')
                    ->where('reminder_time', '<=', now());
    }

    // Accessor untuk waktu reminder
    public function getHumanReminderTimeAttribute()
    {
        return $this->reminder_time->diffForHumans();
    }

    // Tandai reminder sebagai terkirim
    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    // Tandai reminder sebagai gagal
    public function markAsFailed()
    {
        $this->update([
            'status' => 'failed',
        ]);
    }
}