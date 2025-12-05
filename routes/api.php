<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskTemplateController;
use App\Http\Controllers\UserTaskPreferencesController;

// Task routes
Route::middleware('auth:sanctum')->group(function () {
    // Task CRUD
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/today', [TaskController::class, 'getTodayTasks']);
    Route::get('/tasks/overdue', [TaskController::class, 'getOverdueTasks']);
    Route::get('/tasks/upcoming', [TaskController::class, 'getUpcomingTasks']);
    Route::get('/tasks/matrix', [TaskController::class, 'getTasksByMatrix']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    
    // Task actions
    Route::post('/tasks/{id}/complete', [TaskController::class, 'completeTask']);
    Route::post('/tasks/{id}/start', [TaskController::class, 'startTask']);
    Route::post('/tasks/{id}/snooze', [TaskController::class, 'snoozeTask']);
    Route::post('/tasks/{id}/cancel', [TaskController::class, 'cancelTask']);
    Route::post('/tasks/{id}/mood/before', [TaskController::class, 'updateMoodBefore']);
    Route::post('/tasks/{id}/mood/after', [TaskController::class, 'updateMoodAfter']);
    
    // Bulk operations
    Route::post('/tasks/bulk', [TaskController::class, 'bulkUpdate']);
    
    // Statistics
    Route::get('/tasks/statistics', [TaskController::class, 'getStatistics']);
    
    // Subtasks
    Route::get('/tasks/{taskId}/subtasks', [SubtaskController::class, 'index']);
    Route::post('/tasks/{taskId}/subtasks', [SubtaskController::class, 'store']);
    Route::put('/tasks/{taskId}/subtasks/{subtaskId}', [SubtaskController::class, 'update']);
    Route::delete('/tasks/{taskId}/subtasks/{subtaskId}', [SubtaskController::class, 'destroy']);
    Route::post('/tasks/{taskId}/subtasks/reorder', [SubtaskController::class, 'reorder']);
    
    // Templates
    Route::get('/task-templates', [TaskTemplateController::class, 'index']);
    Route::get('/task-templates/popular', [TaskTemplateController::class, 'popular']);
    Route::post('/task-templates', [TaskTemplateController::class, 'store']);
    Route::get('/task-templates/{id}', [TaskTemplateController::class, 'show']);
    Route::put('/task-templates/{id}', [TaskTemplateController::class, 'update']);
    Route::delete('/task-templates/{id}', [TaskTemplateController::class, 'destroy']);
    Route::post('/task-templates/{id}/duplicate', [TaskTemplateController::class, 'duplicate']);
    Route::post('/task-templates/{id}/create-task', [TaskTemplateController::class, 'createTaskFromTemplate']);
    
    // Preferences
    Route::get('/task-preferences', [UserTaskPreferencesController::class, 'show']);
    Route::put('/task-preferences', [UserTaskPreferencesController::class, 'update']);
    Route::post('/task-preferences/reset', [UserTaskPreferencesController::class, 'reset']);
});