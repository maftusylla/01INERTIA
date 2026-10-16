<?php

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\GroupeEtudiantController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [EtudiantController::class, 'index'])
//     ->name('home');


Route::get('/', [ClasseController::class, 'index'])
  ->name('classe.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::post('/groupes/generer', [GroupeEtudiantController::class, 'generer'])
    ->name('groupes.generer');

Route::get('/groupes', [GroupeEtudiantController::class, 'index'])
    ->name('groupes.index');

Route::get('/etudiants', [EtudiantController::class, 'index'])
    ->name('etudiants.index');

Route::post('/etudiants', [EtudiantController::class, 'store'])
    ->name('etudiants.store');

require __DIR__.'/settings.php';

