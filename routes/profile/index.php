<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
Route::get('/profile', function(){
    return view('profile.profile');
})->name('profile');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');