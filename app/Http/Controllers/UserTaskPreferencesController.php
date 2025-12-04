<?php
// app/Http\Controllers\UserTaskPreferencesController.php

namespace App\Http\Controllers;

use App\Models\UserTaskPreferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserTaskPreferencesController extends Controller
{
    /**
     * Get user preferences
     */
    public function show()
    {
        $preferences = Auth::user()->taskPreferences;
        
        if (!$preferences) {
            $preferences = UserTaskPreferences::create([
                'user_id' => Auth::id()
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $preferences,
            'message' => 'Preferences retrieved successfully'
        ]);
    }
    
    /**
     * Update user preferences
     */
    public function update(Request $request)
    {
        $preferences = Auth::user()->taskPreferences;
        
        if (!$preferences) {
            $preferences = UserTaskPreferences::create([
                'user_id' => Auth::id()
            ]);
        }
        
        $validator = Validator::make($request->all(), [
            'enable_reminders' => 'boolean',
            'enable_due_date_reminders' => 'boolean',
            'default_reminder_before' => 'integer|min:1|max:1440',
            'show_completed_tasks' => 'boolean',
            'group_by_category' => 'boolean',
            'default_view' => 'in:list,calendar,matrix',
            'default_category' => 'in:self_care,therapy,medication,exercise,social,work,appointment,mindfulness,creative,chores,other',
            'default_priority' => 'in:low,medium,high,urgent',
            'track_energy_levels' => 'boolean',
            'track_mood_changes' => 'boolean',
            'enable_achievements' => 'boolean',
            'show_progress_bars' => 'boolean',
            'daily_task_limit' => 'integer|min:1|max:50',
            'allow_subtasks' => 'boolean',
            'enable_recurring_tasks' => 'boolean',
            'week_start_day' => 'in:monday,sunday',
            'working_hours_start' => 'nullable|date_format:H:i',
            'working_hours_end' => 'nullable|date_format:H:i',
            'theme' => 'in:light,dark,system',
            'notification_channels' => 'nullable|array',
            'notification_channels.*' => 'in:push,email,sms',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $preferences->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'data' => $preferences->fresh(),
            'message' => 'Preferences updated successfully'
        ]);
    }
    
    /**
     * Reset to default preferences
     */
    public function reset()
    {
        $preferences = Auth::user()->taskPreferences;
        
        if ($preferences) {
            $preferences->delete();
        }
        
        $preferences = UserTaskPreferences::create([
            'user_id' => Auth::id()
        ]);
        
        return response()->json([
            'success' => true,
            'data' => $preferences,
            'message' => 'Preferences reset to default'
        ]);
    }
}