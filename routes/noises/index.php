<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoiseController;
use App\Http\Controllers\SoundController;
use App\Http\Controllers\NoiseTypeController;

Route::prefix('noises')->name('noises.')->group(function () {
    // Main noise routes
    Route::get('/mixed-sounds', [SoundController::class, 'index'])->name('sounds.index');
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
Route::prefix('noise-types')->name('noise-types.')->group(function () {
    Route::get('/', [NoiseTypeController::class, 'index'])->name('index');
    Route::get('/{type}', [NoiseTypeController::class, 'show'])->name('show');
});