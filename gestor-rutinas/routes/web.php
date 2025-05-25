<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('index');
})->name('home');


// Dashboard (solo para usuarios autenticados)

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutinas
    Route::get('/routines', [RoutineController::class, 'index'])->name('routines.index');
    Route::get('/routines/new', [RoutineController::class, 'new'])->name('routines.new');
    Route::post('/routines/store', [RoutineController::class, 'store'])->name('routines.store');
    Route::get('/routines/{id}', [RoutineController::class, 'show'])->name('routines.show');
    Route::get('/routines/{id}/edit', [RoutineController::class, 'edit'])->name('routines.edit');
    Route::put('/routines/{id}', [RoutineController::class, 'update'])->name('routines.update');
    Route::delete('/routines/{id}', [RoutineController::class, 'delete'])->name('routines.delete');

    // Ejercicios
    Route::get('/exercises/new/{routineId}', [ExerciseController::class, 'new'])->name('exercises.new');
    Route::post('/exercises/create', [ExerciseController::class, 'create'])->name('exercises.create');
    Route::get('/exercises/{id}/edit', [ExerciseController::class, 'edit'])->name('exercises.edit');
    Route::post('/exercises/{id}/update', [ExerciseController::class, 'update'])->name('exercises.update');
    Route::delete('/exercises/{id}/delete', [ExerciseController::class, 'delete'])->name('exercises.delete');
});

require __DIR__.'/auth.php';
