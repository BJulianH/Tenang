<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskTemplateController;
use App\Http\Controllers\UserTaskPreferencesController;
use App\Http\Controllers\SubtaskController;

// Task/Todo List Web Routes
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
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Task Actions
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::post('/tasks/{task}/start', [TaskController::class, 'start'])->name('tasks.start');
    Route::post('/tasks/{task}/snooze', [TaskController::class, 'snooze'])->name('tasks.snooze');
    Route::post('/tasks/{task}/cancel', [TaskController::class, 'cancel'])->name('tasks.cancel');
    
    // Subtasks
    Route::post('/tasks/{task}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
    Route::delete('/tasks/{task}/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');
    
    // Templates - ROUTE INI YANG DIPERBAIKI
    Route::get('/task-templates', [TaskTemplateController::class, 'index'])->name('task-templates.index');
    Route::get('/task-templates/create', [TaskTemplateController::class, 'create'])->name('task-templates.create');
    Route::post('/task-templates', [TaskTemplateController::class, 'store'])->name('task-templates.store');
    Route::get('/task-templates/{template}', [TaskTemplateController::class, 'show'])->name('task-templates.show');
    Route::get('/task-templates/{template}/edit', [TaskTemplateController::class, 'edit'])->name('task-templates.edit');
    Route::put('/task-templates/{template}', [TaskTemplateController::class, 'update'])->name('task-templates.update');
    Route::delete('/task-templates/{template}', [TaskTemplateController::class, 'destroy'])->name('task-templates.destroy');
    Route::post('/task-templates/{template}/duplicate', [TaskTemplateController::class, 'duplicate'])->name('task-templates.duplicate');
    Route::post('/task-templates/{template}/create-task', [TaskTemplateController::class, 'createTaskFromTemplate'])->name('task-templates.create-task');
    
    // Preferences
    Route::get('/task-preferences', [UserTaskPreferencesController::class, 'index'])->name('task-preferences.index');
    Route::put('/task-preferences', [UserTaskPreferencesController::class, 'update'])->name('task-preferences.update');
});