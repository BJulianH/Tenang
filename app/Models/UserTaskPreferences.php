<?php
// app/Models/UserTaskPreferences.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTaskPreferences extends Model
{
    use HasFactory;

    protected $table = 'user_task_preferences';

    protected $fillable = [
        'user_id',
        'enable_reminders',
        'enable_due_date_reminders',
        'default_reminder_before',
        'show_completed_tasks',
        'group_by_category',
        'default_view',
        'default_category',
        'default_priority',
        'track_energy_levels',
        'track_mood_changes',
        'enable_achievements',
        'show_progress_bars',
        'daily_task_limit',
        'allow_subtasks',
        'enable_recurring_tasks',
        'week_start_day',
        'working_hours_start',
        'working_hours_end',
        'theme',
        'notification_channels',
    ];

    protected $casts = [
        'enable_reminders' => 'boolean',
        'enable_due_date_reminders' => 'boolean',
        'show_completed_tasks' => 'boolean',
        'group_by_category' => 'boolean',
        'track_energy_levels' => 'boolean',
        'track_mood_changes' => 'boolean',
        'enable_achievements' => 'boolean',
        'show_progress_bars' => 'boolean',
        'allow_subtasks' => 'boolean',
        'enable_recurring_tasks' => 'boolean',
        'notification_channels' => 'array',
        'working_hours_start' => 'datetime:H:i',
        'working_hours_end' => 'datetime:H:i',
    ];

    protected $attributes = [
        'enable_reminders' => true,
        'enable_due_date_reminders' => true,
        'default_reminder_before' => 30,
        'show_completed_tasks' => true,
        'group_by_category' => true,
        'default_view' => 'list',
        'default_category' => 'other',
        'default_priority' => 'medium',
        'track_energy_levels' => true,
        'track_mood_changes' => true,
        'enable_achievements' => true,
        'show_progress_bars' => true,
        'daily_task_limit' => 10,
        'allow_subtasks' => true,
        'enable_recurring_tasks' => true,
        'week_start_day' => 'monday',
        'theme' => 'light',
        'notification_channels' => '["push", "email"]',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get default reminder time
    public function getDefaultReminderTime($dueTime)
    {
        if (!$dueTime || !$this->enable_reminders) {
            return null;
        }
        
        return Carbon::parse($dueTime)->subMinutes($this->default_reminder_before);
    }

    // Check if notification channel is enabled
    public function isChannelEnabled($channel)
    {
        return in_array($channel, $this->notification_channels ?? []);
    }

    // Get working hours as array
    public function getWorkingHoursAttribute()
    {
        return [
            'start' => $this->working_hours_start ? $this->working_hours_start->format('H:i') : '09:00',
            'end' => $this->working_hours_end ? $this->working_hours_end->format('H:i') : '17:00',
        ];
    }
}