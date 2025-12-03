<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminCommunityController;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Posts Management
    Route::get('/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::get('/posts/{post}', [AdminPostController::class, 'show'])->name('admin.posts.show');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::post('/{post}/approve', [AdminPostController::class, 'approve'])->name('admin.posts.approve');
    Route::post('/{post}/disapprove', [AdminPostController::class, 'disapprove'])->name('admin.posts.disapprove');
Route::post('/{post}/feature', [AdminPostController::class, 'feature'])->name('admin.posts.feature');
    Route::post('/{post}/unfeature', [AdminPostController::class, 'unfeature'])->name('admin.posts.unfeature');
    Route::post('/bulk-action', [AdminPostController::class, 'bulkAction'])->name('admin.posts.bulk-action');

    // Communities Management
Route::get('/communities', [AdminCommunityController::class, 'index'])->name('admin.communities.index');
Route::get('/communities/create', [AdminCommunityController::class, 'create'])->name('admin.communities.create');
Route::post('/communities', [AdminCommunityController::class, 'store'])->name('admin.communities.store');
Route::get('/communities/{community}', [AdminCommunityController::class, 'show'])->name('admin.communities.show');
Route::put('/communities/{community}', [AdminCommunityController::class, 'update'])->name('admin.communities.update');
Route::delete('/communities/{community}', [AdminCommunityController::class, 'destroy'])->name('admin.communities.destroy');
Route::get('/communities/{community}/members', [AdminCommunityController::class, 'getMembers'])->name('admin.communities.members');
Route::post('/communities/{community}/moderators', [AdminCommunityController::class, 'addModerator'])->name('admin.communities.moderators.add');
Route::delete('/communities/{community}/moderators/{user}', [AdminCommunityController::class, 'removeModerator'])->name('admin.communities.moderators.remove');
Route::put('/communities/{community}/members/{user}/role', [AdminCommunityController::class, 'updateMemberRole'])->name('admin.communities.members.role');
Route::delete('/communities/{community}/members/{user}', [AdminCommunityController::class, 'removeMember'])->name('admin.communities.members.remove');
Route::post('/communities/bulk-action', [AdminCommunityController::class, 'bulkAction'])->name('admin.communities.bulk-action');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::put('/reports/{report}/resolve', [AdminReportController::class, 'resolve'])->name('admin.reports.resolve');
});