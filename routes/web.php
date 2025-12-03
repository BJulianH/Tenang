<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/main', function () {
    return view('main.index ');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/voice-chat-gemini', function () {
    return view('voice-chat-gemini');
});

require __DIR__.'/route.php';