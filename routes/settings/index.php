<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/profile', [SettingController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/social', [SettingController::class, 'updateSocialLinks'])->name('settings.social.update');
        Route::put('/password', [SettingController::class, 'updatePassword'])->name('settings.password.update');
        Route::put('/notifications', [SettingController::class, 'updateNotifications'])->name('settings.notifications.update');
        Route::put('/privacy', [SettingController::class, 'updatePrivacy'])->name('settings.privacy.update');
        Route::put('/theme', [SettingController::class, 'updateTheme'])->name('settings.theme.update');
        Route::post('/profile-image', [SettingController::class, 'uploadProfileImage'])->name('settings.profile-image.upload');
        Route::post('/cover-image', [SettingController::class, 'uploadCoverImage'])->name('settings.cover-image.upload');
        Route::delete('/account', [SettingController::class, 'deleteAccount'])->name('settings.account.delete');
    });
});