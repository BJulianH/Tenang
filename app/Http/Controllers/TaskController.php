<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskTemplate;
use App\Models\UserTaskPreferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Get all tasks with filters
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->tasks()->with(['subtasks', 'reminders']);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }
        
        if ($request->filled('is_important')) {
            $query->where('is_important', $request->boolean('is_important'));
        }
        
        if ($request->filled('is_urgent')) {
            $query->where('is_urgent', $request->boolean('is_urgent'));
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'due_date');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if ($sortBy === 'priority') {
            $priorityOrder = ['urgent' => 1, 'high' => 2, 'medium' => 3, 'low' => 4];
            $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low') {$sortOrder}");
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $tasks = $query->paginate($request->get('per_page', 20));
        
        // Get statistics
        $statistics = $user->getTaskStatistics();
        
        return response()->json([
            'success' => true,
            'data' => $tasks,
            'statistics' => $statistics,
            'message' => 'Tasks retrieved successfully'
        ]);
    }
    
    /**
     * Get today's tasks
     */
    public function getTodayTasks(Request $request)
    {
        $user = Auth::user();
        
        $tasks = $user->tasks()
            ->dueToday()
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with(['subtasks' => function($q) {
                $q->whereNotIn('status', ['completed', 'cancelled']);
            }])
            ->orderBy('priority', 'desc')
            ->orderBy('due_time')
            ->get();
        
        $overdue = $user->tasks()
            ->where('due_date', '<', Carbon::today())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();
        
        $completedToday = $user->tasks()
            ->whereDate('completed_at', Carbon::today())
            ->count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'tasks' => $tasks,
                'overdue_count' => $overdue,
                'completed_today' => $completedToday,
                'total_today' => $tasks->count(),
            ],
            'message' => 'Today\'s tasks retrieved successfully'
        ]);
    }
    
    /**
     * Get overdue tasks
     */
    public function getOverdueTasks(Request $request)
    {
        $user = Auth::user();
        
        $tasks = $user->tasks()
            ->where('due_date', '<', Carbon::today())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with('subtasks')
            ->orderBy('due_date')
            ->orderBy('priority', 'desc')
            ->paginate($request->get('per_page', 20));
        
        return response()->json([
            'success' => true,
            'data' => $tasks,
            'message' => 'Overdue tasks retrieved successfully'
        ]);
    }
    
    /**
     * Get upcoming tasks (next 7 days)
     */
    public function getUpcomingTasks(Request $request)
    {
        $user = Auth::user();
        
        $tasks = $user->tasks()
            ->whereBetween('due_date', [Carbon::today(), Carbon::today()->addDays(7)])
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with('subtasks')
            ->orderBy('due_date')
            ->orderBy('due_time')
            ->paginate($request->get('per_page', 20));
        
        return response()->json([
            'success' => true,
            'data' => $tasks,
            'message' => 'Upcoming tasks retrieved successfully'
        ]);
    }
    
    /**
     * Get tasks by Eisenhower Matrix
     */
    public function getTasksByMatrix(Request $request)
    {
        $user = Auth::user();
        $quadrant = $request->get('quadrant', 'important_urgent');
        
        $query = $user->tasks()
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with('subtasks');
        
        switch ($quadrant) {
            case 'important_urgent':
                $query->where('is_important', true)->where('is_urgent', true);
                break;
            case 'important_not_urgent':
                $query->where('is_important', true)->where('is_urgent', false);
                break;
            case 'not_important_urgent':
                $query->where('is_important', false)->where('is_urgent', true);
                break;
            case 'not_important_not_urgent':
                $query->where('is_important', false)->where('is_urgent', false);
                break;
        }
        
        $tasks = $query->orderBy('due_date')
                      ->orderBy('priority', 'desc')
                      ->paginate($request->get('per_page', 20));
        
        return response()->json([
            'success' => true,
            'data' => [
                'quadrant' => $quadrant,
                'tasks' => $tasks,
            ],
            'message' => 'Tasks by matrix retrieved successfully'
        ]);
    }
    
    /**
     * Store a new task
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:self_care,therapy,medication,exercise,social,work,appointment,mindfulness,creative,chores,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date|after_or_equal:today',
            'due_time' => 'nullable|date_format:H:i',
            'is_important' => 'boolean',
            'is_urgent' => 'boolean',
            'estimated_duration' => 'nullable|integer|min:1',
            'energy_level_required' => 'nullable|integer|min:1|max:5',
            'difficulty_level' => 'nullable|integer|min:1|max:5',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'parent_id' => 'nullable|exists:tasks,id',
            'template_id' => 'nullable|exists:task_templates,id',
            'is_recurring' => 'boolean',
            'recurring_pattern' => 'nullable|in:daily,weekly,monthly,weekdays,weekends,custom',
            'recurring_days' => 'nullable|array',
            'recurring_days.*' => 'integer|min:0|max:6',
            'recurring_end_date' => 'nullable|date|after:due_date',
            'reminder_before' => 'nullable|integer|min:1|max:1440',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $validated = $validator->validated();
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        
        // Set default values from preferences
        $preferences = Auth::user()->taskPreferences;
        if ($preferences) {
            $validated['category'] = $validated['category'] ?? $preferences->default_category;
            $validated['priority'] = $validated['priority'] ?? $preferences->default_priority;
            $validated['reminder_before'] = $validated['reminder_before'] ?? $preferences->default_reminder_before;
        }
        
        // Create task
        $task = Task::create($validated);
        
        // Create reminder if enabled
        if ($preferences && $preferences->enable_reminders && 
            $validated['due_date'] && $validated['due_time']) {
            
            $dueDateTime = Carbon::parse($validated['due_date'] . ' ' . $validated['due_time']);
            $reminderTime = $dueDateTime->subMinutes($validated['reminder_before']);
            
            $task->reminders()->create([
                'reminder_time' => $reminderTime,
                'status' => 'pending',
                'channel' => 'push',
                'message' => "Reminder: {$task->title} due at {$dueDateTime->format('H:i')}",
            ]);
        }
        
        // Update user stats
        Auth::user()->increment('tasks_created');
        
        return response()->json([
            'success' => true,
            'data' => $task->load(['subtasks', 'reminders']),
            'message' => 'Task created successfully'
        ], 201);
    }
    
    /**
     * Show a specific task
     */
    public function show($id)
    {
        $task = Auth::user()->tasks()
            ->with(['subtasks', 'reminders', 'completions', 'template'])
            ->findOrFail($id);
        
        $completionRate = $task->getCompletionRate();
        $moodImprovement = $task->getMoodImprovement();
        
        return response()->json([
            'success' => true,
            'data' => [
                'task' => $task,
                'stats' => [
                    'completion_rate' => $completionRate,
                    'mood_improvement' => $moodImprovement,
                    'streak_count' => $task->streak_count,
                    'completion_count' => $task->completion_count,
                ]
            ],
            'message' => 'Task retrieved successfully'
        ]);
    }
    
    /**
     * Update a task
     */
    public function update(Request $request, $id)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        
        // Can't update completed or cancelled tasks
        if (in_array($task->status, ['completed', 'cancelled'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update completed or cancelled tasks'
            ], 400);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'category' => 'in:self_care,therapy,medication,exercise,social,work,appointment,mindfulness,creative,chores,other',
            'priority' => 'in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'is_important' => 'boolean',
            'is_urgent' => 'boolean',
            'estimated_duration' => 'nullable|integer|min:1',
            'energy_level_required' => 'nullable|integer|min:1|max:5',
            'difficulty_level' => 'nullable|integer|min:1|max:5',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'status' => 'in:pending,in_progress,completed,cancelled,snoozed',
            'reminder_before' => 'nullable|integer|min:1|max:1440',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $validated = $validator->validated();
        
        // Handle completion
        if (isset($validated['status']) && $validated['status'] === 'completed') {
            $moodBefore = $request->get('mood_before');
            $moodAfter = $request->get('mood_after');
            $notes = $request->get('notes');
            $actualDuration = $request->get('actual_duration');
            
            $result = $task->markAsCompleted($moodBefore, $moodAfter, $notes, $actualDuration);
            
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Task marked as completed successfully'
            ]);
        }
        
        // Handle snooze
        if (isset($validated['status']) && $validated['status'] === 'snoozed') {
            $snoozeMinutes = $request->get('snooze_minutes', 30);
            $task->snooze($snoozeMinutes);
            
            return response()->json([
                'success' => true,
                'data' => $task->fresh(),
                'message' => 'Task snoozed successfully'
            ]);
        }
        
        // Regular update
        $task->update($validated);
        
        return response()->json([
            'success' => true,
            'data' => $task->fresh()->load(['subtasks', 'reminders']),
            'message' => 'Task updated successfully'
        ]);
    }
    
    /**
     * Mark task as completed
     */
    public function completeTask(Request $request, $id)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        
        // Check if task can be completed (all subtasks completed)
        if (!$task->canBeCompleted()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot complete task: Not all subtasks are completed'
            ], 400);
        }
        
        $validator = Validator::make($request->all(), [
            'mood_before' => 'nullable|integer|min:1|max:5',
            'mood_after' => 'nullable|integer|min:1|max:5',
            'notes' => 'nullable|string|max:1000',
            'actual_duration' => 'nullable|integer|min:1',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $validated = $validator->validated();
        
        $result = $task->markAsCompleted(
            $validated['mood_before'] ?? null,
            $validated['mood_after'] ?? null,
            $validated['notes'] ?? null,
            $validated['actual_duration'] ?? null
        );
        
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Task completed successfully'
        ]);
    }
    
    /**
     * Update mood before task
     */
    public function updateMoodBefore(Request $request, $id)
    {
        $request->validate([
            'mood' => 'required|integer|min:1|max:5'
        ]);
        
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->updateMoodBefore($request->mood);
        
        return response()->json([
            'success' => true,
            'data' => $task->fresh(),
            'message' => 'Mood before task updated successfully'
        ]);
    }
    
    /**
     * Update mood after task
     */
    public function updateMoodAfter(Request $request, $id)
    {
        $request->validate([
            'mood' => 'required|integer|min:1|max:5'
        ]);
        
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->updateMoodAfter($request->mood);
        
        return response()->json([
            'success' => true,
            'data' => $task->fresh(),
            'message' => 'Mood after task updated successfully'
        ]);
    }
    
    /**
     * Mark task as in progress
     */
    public function startTask($id)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->markAsInProgress();
        
        return response()->json([
            'success' => true,
            'data' => $task->fresh(),
            'message' => 'Task marked as in progress'
        ]);
    }
    
    /**
     * Snooze task
     */
    public function snoozeTask(Request $request, $id)
    {
        $request->validate([
            'minutes' => 'required|integer|min:1|max:1440'
        ]);
        
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->snooze($request->minutes);
        
        return response()->json([
            'success' => true,
            'data' => $task->fresh(),
            'message' => 'Task snoozed successfully'
        ]);
    }
    
    /**
     * Delete a task
     */
    public function destroy($id)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        
        // Check if task has completions
        if ($task->completions()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete task with completion history. Cancel instead.'
            ], 400);
        }
        
        $task->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }
    
    /**
     * Cancel a task
     */
    public function cancelTask($id)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        
        if ($task->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot cancel completed task'
            ], 400);
        }
        
        $task->update(['status' => 'cancelled']);
        
        return response()->json([
            'success' => true,
            'data' => $task->fresh(),
            'message' => 'Task cancelled successfully'
        ]);
    }
    
    /**
     * Get task statistics
     */
    public function getStatistics(Request $request)
    {
        $user = Auth::user();
        
        // Weekly statistics
        $startDate = $request->get('start_date', Carbon::today()->startOfWeek());
        $endDate = $request->get('end_date', Carbon::today()->endOfWeek());
        
        $completions = $user->taskCompletions()
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->get();
        
        // Group by day
        $dailyStats = [];
        $currentDate = Carbon::parse($startDate);
        
        while ($currentDate <= Carbon::parse($endDate)) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayCompletions = $completions->filter(function($completion) use ($dateStr) {
                return $completion->completed_at->format('Y-m-d') === $dateStr;
            });
            
            $dailyStats[$dateStr] = [
                'date' => $dateStr,
                'day_name' => $currentDate->translatedFormat('l'),
                'total_completed' => $dayCompletions->count(),
                'total_points' => $dayCompletions->sum('points_earned'),
                'avg_mood_before' => $dayCompletions->avg('mood_before'),
                'avg_mood_after' => $dayCompletions->avg('mood_after'),
                'tasks' => $dayCompletions->map(function($completion) {
                    return [
                        'task_title' => $completion->task->title,
                        'points_earned' => $completion->points_earned,
                        'mood_before' => $completion->mood_before,
                        'mood_after' => $completion->mood_after,
                    ];
                })
            ];
            
            $currentDate->addDay();
        }
        
        // Category statistics
        $categoryStats = $user->tasks()
            ->selectRaw('category, COUNT(*) as total, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            ->groupBy('category')
            ->get()
            ->map(function($stat) {
                $stat->completion_rate = $stat->total > 0 ? round(($stat->completed / $stat->total) * 100, 2) : 0;
                return $stat;
            });
        
        // Priority statistics
        $priorityStats = $user->tasks()
            ->selectRaw('priority, COUNT(*) as total, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            ->groupBy('priority')
            ->get();
        
        // Overall statistics
        $overallStats = $user->getTaskStatistics();
        
        return response()->json([
            'success' => true,
            'data' => [
                'overall' => $overallStats,
                'daily' => array_values($dailyStats),
                'categories' => $categoryStats,
                'priorities' => $priorityStats,
                'streak' => $user->task_streak,
                'completion_rate_trend' => $this->getCompletionRateTrend($user, 30),
            ],
            'message' => 'Statistics retrieved successfully'
        ]);
    }
    
    /**
     * Get completion rate trend
     */
    private function getCompletionRateTrend($user, $days = 30)
    {
        $trend = [];
        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subDays($days - 1);
        
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $completed = $user->taskCompletions()
                ->whereDate('completed_at', $currentDate)
                ->count();
            
            $created = $user->tasks()
                ->whereDate('created_at', $currentDate)
                ->count();
            
            $rate = $created > 0 ? round(($completed / $created) * 100, 2) : 0;
            
            $trend[] = [
                'date' => $currentDate->format('Y-m-d'),
                'completed' => $completed,
                'created' => $created,
                'rate' => $rate,
            ];
            
            $currentDate->addDay();
        }
        
        return $trend;
    }
    
    /**
     * Bulk update tasks
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:tasks,id,user_id,' . Auth::id(),
            'action' => 'required|in:complete,cancel,delete,update_priority,update_category',
            'data' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $taskIds = $request->task_ids;
        $action = $request->action;
        $data = $request->data ?? [];
        
        $updatedTasks = [];
        $failedTasks = [];
        
        foreach ($taskIds as $taskId) {
            try {
                $task = Auth::user()->tasks()->find($taskId);
                
                if (!$task) continue;
                
                switch ($action) {
                    case 'complete':
                        if ($task->canBeCompleted()) {
                            $task->markAsCompleted();
                            $updatedTasks[] = $task;
                        } else {
                            $failedTasks[] = [
                                'id' => $taskId,
                                'reason' => 'Cannot complete task with incomplete subtasks'
                            ];
                        }
                        break;
                        
                    case 'cancel':
                        if ($task->status !== 'completed') {
                            $task->update(['status' => 'cancelled']);
                            $updatedTasks[] = $task;
                        }
                        break;
                        
                    case 'delete':
                        if ($task->completions()->count() === 0) {
                            $task->delete();
                            $updatedTasks[] = ['id' => $taskId, 'deleted' => true];
                        } else {
                            $failedTasks[] = [
                                'id' => $taskId,
                                'reason' => 'Cannot delete task with completion history'
                            ];
                        }
                        break;
                        
                    case 'update_priority':
                        if (isset($data['priority'])) {
                            $task->update(['priority' => $data['priority']]);
                            $updatedTasks[] = $task;
                        }
                        break;
                        
                    case 'update_category':
                        if (isset($data['category'])) {
                            $task->update(['category' => $data['category']]);
                            $updatedTasks[] = $task;
                        }
                        break;
                }
            } catch (\Exception $e) {
                $failedTasks[] = [
                    'id' => $taskId,
                    'reason' => $e->getMessage()
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'updated' => $updatedTasks,
                'failed' => $failedTasks,
                'total_updated' => count($updatedTasks),
                'total_failed' => count($failedTasks),
            ],
            'message' => 'Bulk operation completed'
        ]);
    }
    // Di TaskController.php
public function dashboard()
{
    return view('tasks.dashboard');
}

public function today()
{
    return view('tasks.today');
}

public function upcoming()
{
    return view('tasks.upcoming');
}

public function overdue()
{
    return view('tasks.overdue');
}

public function matrix()
{
    return view('tasks.matrix');
}

public function statistics()
{
    return view('tasks.statistics');
}

public function calendar()
{
    return view('tasks.calendar');
}

public function create()
{
    return view('tasks.create');
}


public function edit(Task $task)
{
    $this->authorize('update', $task);
    return view('tasks.edit', compact('task'));
}
}