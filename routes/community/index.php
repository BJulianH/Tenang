<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityProfileController;

Route::prefix('community')->group(function () {
    // Community routes
    Route::get('/', [CommunityController::class, 'index'])->name('community.index');
    Route::get('/explore', [CommunityController::class, 'explore'])->name('community.explore');
    Route::get('/create', [CommunityController::class, 'create'])->name('community.create');
    Route::post('/create', [CommunityController::class, 'store'])->name('community.store');
    Route::get('/my', [CommunityController::class, 'myCommunities'])->name('community.my');
    Route::get('/{community:slug}', [CommunityController::class, 'show'])->name('community.show');
    Route::get('/{community:slug}/manage', [CommunityController::class, 'manage'])->name('community.manage');
    
    // Community interaction routes
    Route::post('/{community}/join', [CommunityController::class, 'join'])->name('communities.join');
    Route::post('/{community}/leave', [CommunityController::class, 'leave'])->name('communities.leave');

    // Post routes
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    
    // Post interaction routes
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');
    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('posts.save');
    Route::post('/posts/{post}/unsave', [PostController::class, 'unsave'])->name('posts.unsave');

    // Comment routes
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::post('/comments/{comment}/unlike', [CommentController::class, 'unlike'])->name('comments.unlike');
    Route::prefix('profile')->group(function () {
        Route::get('/{user:username}', [CommunityProfileController::class, 'show'])->name('profile.community');
        Route::get('/{user:username}/posts', [CommunityProfileController::class, 'posts'])->name('profile.posts');
        Route::get('/{user:username}/comments', [CommunityProfileController::class, 'comments'])->name('profile.comments');
        Route::get('/{user:username}/communities', [CommunityProfileController::class, 'communities'])->name('profile.communities');
        
        Route::middleware('auth')->group(function () {
            Route::get('/edit', [CommunityProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/update', [CommunityProfileController::class, 'update'])->name('profile.update');
            Route::put('/update-preferences', [CommunityProfileController::class, 'updatePreferences'])->name('profile.preferences');
            Route::put('/update-password', [CommunityProfileController::class, 'updatePassword'])->name('profile.password');
            Route::delete('/delete-profile-image', [CommunityProfileController::class, 'deleteProfileImage'])->name('profile.delete-image');
            Route::delete('/delete-cover-image', [CommunityProfileController::class, 'deleteCoverImage'])->name('profile.delete-cover');
        });
    });
});
Route::get('/profile/{user:username}', [CommunityProfileController::class, 'show'])->name('profile.community');
