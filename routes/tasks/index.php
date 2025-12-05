<?php
// routes/web.php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskTemplateController;
use App\Http\Controllers\UserTaskPreferencesController;

// Task/Todo List Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Tasks Dashboard
    Route::get('/tasks', [TaskController::class, 'dashboard'])->name('tasks.dashboard');
    
    // Task Views
    Route::get('/tasks/today', [TaskController::class, 'today'])->name('tasks.today');
    Route::get('/tasks/upcoming', [TaskController::class, 'upcoming'])->name('tasks.upcoming');
    Route::get('/tasks/overdue', [TaskController::class, 'overdue'])->name('tasks.overdue');
    Route::get('/tasks/matrix', [TaskController::class, 'matrix'])->name('tasks.matrix');
    Route::get('/tasks/statistics', [TaskController::class, 'statistics'])->name('tasks.statistics');
    Route::get('/tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');
    
    // Task CRUD
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    
    // Subtasks
    Route::get('/tasks/{task}/subtasks', [SubtaskController::class, 'index'])->name('subtasks.index');
    
    // Templates
    Route::get('/task-templates', [TaskTemplateController::class, 'index'])->name('task-templates.index');
    Route::get('/task-templates/create', [TaskTemplateController::class, 'create'])->name('task-templates.create');
    Route::get('/task-templates/{template}/edit', [TaskTemplateController::class, 'edit'])->name('task-templates.edit');
    
    // Preferences
    Route::get('/task-preferences', [UserTaskPreferencesController::class, 'edit'])->name('task-preferences.edit');
});