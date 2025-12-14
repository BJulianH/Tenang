<?php
// app/Http/Controllers/TaskTemplateController.php

namespace App\Http\Controllers;

use App\Models\TaskTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskTemplateController extends Controller
{
    // WEB METHODS
    
    /**
     * Display a listing of templates
     */
    public function index()
    {
        $user = Auth::user();
        
        $templates = TaskTemplate::where('user_id', $user->id)
            ->orWhere('is_public', true)
            ->orderBy('usage_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('templates.index', compact('templates'));
    }
    
    /**
     * Show the form for creating a new template
     */
    public function create()
    {
        return view('templates.create');
    }
    
    /**
     * Store a newly created template
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:self_care,therapy,medication,exercise,social,work,appointment,mindfulness,creative,chores,other',
            'estimated_duration' => 'nullable|integer|min:1',
            'energy_level_required' => 'nullable|integer|min:1|max:5',
            'difficulty_level' => 'nullable|integer|min:1|max:5',
            'priority' => 'required|in:low,medium,high,urgent',
            'is_important' => 'boolean',
            'is_urgent' => 'boolean',
            'tags' => 'nullable|string',
            'is_public' => 'boolean',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        if (!empty($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = json_encode($tags);
        }
        
        TaskTemplate::create($validated);
        
        return redirect()->route('task-templates.index')
            ->with('success', 'Template berhasil dibuat!');
    }
    
    /**
     * Display the specified template
     */
    public function show(TaskTemplate $template)
    {
        // Check authorization
        if (!$template->is_public && $template->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('templates.show', compact('template'));
    }
    
    /**
     * Show the form for editing the specified template
     */
    public function edit(TaskTemplate $template)
    {
        $this->authorize('update', $template);
        
        return view('templates.edit', compact('template'));
    }
    
    /**
     * Update the specified template
     */
    public function update(Request $request, TaskTemplate $template)
    {
        $this->authorize('update', $template);
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'category' => 'in:self_care,therapy,medication,exercise,social,work,appointment,mindfulness,creative,chores,other',
            'estimated_duration' => 'nullable|integer|min:1',
            'energy_level_required' => 'nullable|integer|min:1|max:5',
            'difficulty_level' => 'nullable|integer|min:1|max:5',
            'priority' => 'in:low,medium,high,urgent',
            'is_important' => 'boolean',
            'is_urgent' => 'boolean',
            'tags' => 'nullable|string',
            'is_public' => 'boolean',
        ]);
        
        if (!empty($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = json_encode($tags);
        }
        
        $template->update($validated);
        
        return redirect()->route('task-templates.index')
            ->with('success', 'Template berhasil diperbarui!');
    }
    
    /**
     * Remove the specified template
     */
    public function destroy(TaskTemplate $template)
    {
        $this->authorize('delete', $template);
        
        $template->delete();
        
        return redirect()->route('task-templates.index')
            ->with('success', 'Template berhasil dihapus!');
    }
    
    /**
     * Duplicate a template
     */
    public function duplicate(TaskTemplate $template)
    {
        $newTemplate = $template->replicate();
        $newTemplate->user_id = Auth::id();
        $newTemplate->is_public = false;
        $newTemplate->usage_count = 0;
        $newTemplate->save();
        
        return redirect()->route('task-templates.index')
            ->with('success', 'Template berhasil diduplikasi!');
    }
    
    /**
     * Create task from template
     */
    public function createTaskFromTemplate(Request $request, TaskTemplate $template)
    {
        // Check authorization
        if (!$template->is_public && $template->user_id !== Auth::id()) {
            abort(403);
        }
        
        $task = $template->createTask(
            Auth::id(),
            $request->due_date,
            $request->due_time
        );
        
        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task berhasil dibuat dari template!');
    }
    
    // API METHODS (tambahkan jika perlu)
    public function popular()
    {
        $templates = TaskTemplate::where('is_public', true)
            ->orderBy('usage_count', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $templates
        ]);
    }
}