<?php
// app/Http/Controllers/TaskTemplateController.php

namespace App\Http\Controllers;

use App\Models\TaskTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskTemplateController extends Controller
{
    /**
     * Get all templates (user's + public)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = TaskTemplate::forUser($user->id);
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $templates = $query->orderBy('usage_count', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->paginate($request->get('per_page', 20));
        
        return response()->json([
            'success' => true,
            'data' => $templates,
            'message' => 'Templates retrieved successfully'
        ]);
    }
    
    /**
     * Store a new template
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:self_care,therapy,medication,exercise,social,work,appointment,mindfulness,creative,chores,other',
            'estimated_duration' => 'nullable|integer|min:1',
            'energy_level_required' => 'nullable|integer|min:1|max:5',
            'difficulty_level' => 'nullable|integer|min:1|max:5',
            'priority' => 'required|in:low,medium,high,urgent',
            'is_important' => 'boolean',
            'is_urgent' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_public' => 'boolean',
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
        
        $template = TaskTemplate::create($validated);
        
        return response()->json([
            'success' => true,
            'data' => $template,
            'message' => 'Template created successfully'
        ], 201);
    }
    
    /**
     * Show a specific template
     */
    public function show($id)
    {
        $user = Auth::user();
        $template = TaskTemplate::forUser($user->id)->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $template,
            'message' => 'Template retrieved successfully'
        ]);
    }
    
    /**
     * Update a template
     */
    public function update(Request $request, $id)
    {
        $template = Auth::user()->taskTemplates()->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'category' => 'in:self_care,therapy,medication,exercise,social,work,appointment,mindfulness,creative,chores,other',
            'estimated_duration' => 'nullable|integer|min:1',
            'energy_level_required' => 'nullable|integer|min:1|max:5',
            'difficulty_level' => 'nullable|integer|min:1|max:5',
            'priority' => 'in:low,medium,high,urgent',
            'is_important' => 'boolean',
            'is_urgent' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_public' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $template->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'data' => $template->fresh(),
            'message' => 'Template updated successfully'
        ]);
    }
    
    /**
     * Delete a template
     */
    public function destroy($id)
    {
        $template = Auth::user()->taskTemplates()->findOrFail($id);
        $template->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Template deleted successfully'
        ]);
    }
    
    /**
     * Create task from template
     */
    public function createTaskFromTemplate(Request $request, $id)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'due_date' => 'nullable|date|after_or_equal:today',
            'due_time' => 'nullable|date_format:H:i',
            'custom_title' => 'nullable|string|max:255',
            'custom_description' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $task = $user->createTaskFromTemplate(
            $id,
            $request->due_date,
            $request->due_time
        );
        
        // Customize if needed
        if ($request->filled('custom_title')) {
            $task->update(['title' => $request->custom_title]);
        }
        
        if ($request->filled('custom_description')) {
            $task->update(['description' => $request->custom_description]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task created from template successfully'
        ], 201);
    }
    
    /**
     * Duplicate a template
     */
    public function duplicate($id)
    {
        $user = Auth::user();
        $template = TaskTemplate::forUser($user->id)->findOrFail($id);
        
        $newTemplate = $template->replicate();
        $newTemplate->user_id = $user->id;
        $newTemplate->is_public = false;
        $newTemplate->usage_count = 0;
        $newTemplate->save();
        
        return response()->json([
            'success' => true,
            'data' => $newTemplate,
            'message' => 'Template duplicated successfully'
        ], 201);
    }
    
    /**
     * Get popular templates
     */
    public function popular()
    {
        $templates = TaskTemplate::where('is_public', true)
            ->orderBy('usage_count', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $templates,
            'message' => 'Popular templates retrieved successfully'
        ]);
    }
}