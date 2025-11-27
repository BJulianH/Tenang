<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NoiseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\NoiseTypeController;
use App\Http\Controllers\CommunityProfileController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/voice-chat-gemini', function () {
    return view('voice-chat-gemini');
});
// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

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
Route::prefix('noises')->name('noises.')->group(function () {
    // Main noise routes
    Route::get('/', [NoiseController::class, 'index'])->name('index');
    Route::get('/type/{type}', [NoiseController::class, 'byType'])->name('by-type');
    Route::get('/use-case/{useCase}', [NoiseController::class, 'byUseCase'])->name('by-use-case');
    Route::get('/search', [NoiseController::class, 'search'])->name('search');
    Route::get('/{noise}', [NoiseController::class, 'show'])->name('show');
    
    // Actions
    Route::post('/{noise}/play', [NoiseController::class, 'incrementPlayCount'])->name('play');
    Route::post('/{noise}/favorite', [NoiseController::class, 'toggleFavorite'])->name('favorite');
    Route::post('/{noise}/save', [NoiseController::class, 'toggleSave'])->name('save');
});

// Noise types routes (optional separate prefix)
Route::prefix('noise-types')->name('noise-types.')->group(function () {
    Route::get('/', [NoiseTypeController::class, 'index'])->name('index');
    Route::get('/{type}', [NoiseTypeController::class, 'show'])->name('show');
});
// Profile routes
Route::get('/profile/{user:username}', [CommunityProfileController::class, 'show'])->name('profile.community');

// Support groups routes
Route::get('/support-groups', [SupportGroupController::class, 'index'])->name('support-groups.index');

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
    
    // Communities Management
    Route::get('/communities', [AdminCommunityController::class, 'index'])->name('admin.communities.index');
    Route::get('/communities/{community}', [AdminCommunityController::class, 'show'])->name('admin.communities.show');
    Route::put('/communities/{community}', [AdminCommunityController::class, 'update'])->name('admin.communities.update');
    Route::delete('/communities/{community}', [AdminCommunityController::class, 'destroy'])->name('admin.communities.destroy');
    
    // Reports Management
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::put('/reports/{report}/resolve', [AdminReportController::class, 'resolve'])->name('admin.reports.resolve');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');
    Route::put('/journal/{journal}', [JournalController::class, 'update'])->name('journal.update');
    Route::delete('/journal/{journal}', [JournalController::class, 'destroy'])->name('journal.destroy');
});
