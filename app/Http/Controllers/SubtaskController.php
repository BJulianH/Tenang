<?php
// app/Http/Controllers/SubtaskController.php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubtaskController extends Controller
{
    /**
     * Get all subtasks for a task
     */
    public function index($taskId)
    {
        $task = Auth::user()->tasks()->findOrFail($taskId);
        $subtasks = $task->subtasks()->with('subtasks')->get();
        
        return response()->json([
            'success' => true,
            'data' => $subtasks,
            'message' => 'Subtasks retrieved successfully'
        ]);
    }
    
    /**
     * Store a new subtask
     */
    public function store(Request $request, $taskId)
    {
        $parentTask = Auth::user()->tasks()->findOrFail($taskId);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date|after_or_equal:today',
            'due_time' => 'nullable|date_format:H:i',
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
        $validated['parent_id'] = $taskId;
        $validated['status'] = 'pending';
        $validated['category'] = $parentTask->category;
        
        $subtask = Task::create($validated);
        
        return response()->json([
            'success' => true,
            'data' => $subtask,
            'message' => 'Subtask created successfully'
        ], 201);
    }
    
    /**
     * Update a subtask
     */
    public function update(Request $request, $taskId, $subtaskId)
    {
        $parentTask = Auth::user()->tasks()->findOrFail($taskId);
        $subtask = $parentTask->subtasks()->findOrFail($subtaskId);
        
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'priority' => 'in:low,medium,high,urgent',
            'status' => 'in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $subtask->update($validator->validated());
        
        // Check if parent task can now be completed
        if ($parentTask->canBeCompleted() && $parentTask->status === 'pending') {
            // Optionally auto-complete parent task
            // $parentTask->markAsCompleted();
        }
        
        return response()->json([
            'success' => true,
            'data' => $subtask->fresh(),
            'message' => 'Subtask updated successfully'
        ]);
    }
    
    /**
     * Delete a subtask
     */
    public function destroy($taskId, $subtaskId)
    {
        $parentTask = Auth::user()->tasks()->findOrFail($taskId);
        $subtask = $parentTask->subtasks()->findOrFail($subtaskId);
        
        $subtask->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Subtask deleted successfully'
        ]);
    }
    
    /**
     * Reorder subtasks
     */
    public function reorder(Request $request, $taskId)
    {
        $request->validate([
            'subtask_ids' => 'required|array',
            'subtask_ids.*' => 'exists:tasks,id,parent_id,' . $taskId
        ]);
        
        $parentTask = Auth::user()->tasks()->findOrFail($taskId);
        
        foreach ($request->subtask_ids as $index => $subtaskId) {
            $parentTask->subtasks()
                ->where('id', $subtaskId)
                ->update(['order' => $index]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Subtasks reordered successfully'
        ]);
    }
}