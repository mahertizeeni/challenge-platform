<?php


use App\Http\Controllers\ContestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameSessionController;

Route::middleware('auth')->group(function () {
    Route::get('/game-sessions/create', [GameSessionController::class, 'create'])->name('game_sessions.create');
    Route::post('/game-sessions', [GameSessionController::class, 'store'])->name('game_sessions.store');
    Route::get('/game-sessions/{gameSession}/play', [GameSessionController::class, 'play'])->name('game_sessions.play');
    Route::post('/contestants/{contestant}/score', [GameSessionController::class, 'updateScore'])->name('contestants.updateScore');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
