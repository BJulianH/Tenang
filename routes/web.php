<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});
// Auth Pages
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


