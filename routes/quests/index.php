<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestController;

Route::prefix('quests')->group(function () {
    Route::get('/me', [QuestController::class, 'indexView'])->name('quests.index.view');
    Route::get('/achievements', [QuestController::class, 'achievements'])->name('quests.achievements');
    Route::get('/', [QuestController::class, 'index'])->name('quests.index');
    Route::get('/available', [QuestController::class, 'availableQuests'])->name('quests.available');
    
    Route::post('/assign-random', [QuestController::class, 'assignRandomQuests'])->name('quests.assign-random');
    Route::post('/choose', [QuestController::class, 'chooseQuests'])->name('quests.choose');

    Route::post('/{userQuest}/complete', [QuestController::class, 'completeQuest'])->name('quests.complete');
    Route::post('/{userQuest}/claim', [QuestController::class, 'claimRewards'])->name('quests.claim');

    Route::patch('/{userQuest}/progress', [QuestController::class, 'updateProgress'])->name('quests.progress');
    Route::patch('/{userQuest}/add-progress', [QuestController::class, 'addProgress'])->name('quests.add-progress');

    Route::get('/stats', [QuestController::class, 'stats'])->name('quests.stats');
    Route::post('/reset', [QuestController::class, 'resetQuests'])->name('quests.reset');
});
Route::get('/achievements', [QuestController::class, 'achievements'])->name('quests.achievements');
