<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

Route::get('/curhat', [ChatbotController::class, 'index'])->name('curhat.index');
Route::post('/curhat/send', [ChatbotController::class, 'send'])->name('curhat.send');
Route::post('/curhat/clear', [ChatbotController::class, 'clear'])->name('curhat.clear');
