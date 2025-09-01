<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (\Illuminate\Http\Request $request) {
    if (auth()->user()->role == 'admin') {
        return to_route('dashboard');
    }
    return to_route('teams.index');
})->middleware('auth');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/teams', [\App\Http\Controllers\TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams/create', [\App\Http\Controllers\TeamController::class, 'create'])->name('teams.create');
    Route::post('/games', [\App\Http\Controllers\GameController::class, 'create'])->name('games.create');

    Route::post('/teams', [\App\Http\Controllers\GameController::class, 'apply'])->name('apply');
});

require __DIR__.'/auth.php';
