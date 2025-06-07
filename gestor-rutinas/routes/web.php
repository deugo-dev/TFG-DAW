<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoutineExerciseController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard y perfil
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // rutinas
    Route::get('/routines', [RoutineController::class, 'index'])->name('routines.index');
    Route::get('/routines/new', [RoutineController::class, 'new'])->name('routines.new');
    Route::post('/routines/store', [RoutineController::class, 'store'])->name('routines.store');
    Route::get('/routines/{routine}', [RoutineController::class, 'show'])->name('routines.show');
    Route::get('/routines/{routine}/edit', [RoutineController::class, 'edit'])->name('routines.edit');
    Route::put('/routines/{routine}', [RoutineController::class, 'update'])->name('routines.update');
    Route::delete('/routines/{routine}', [RoutineController::class, 'delete'])->name('routines.delete');

    // asociar ejercicios a rutinas 
    Route::prefix('routines/{routine}')->group(function () {
        Route::post('/exercises/store', [RoutineExerciseController::class, 'store'])->name('routine_exercises.store');
        Route::put('/exercises/{exercise}', [RoutineExerciseController::class, 'update'])->name('routine_exercises.update');
        Route::delete('/exercises/{exercise}', [RoutineExerciseController::class, 'delete'])->name('routine_exercises.delete');
    });

    // rutas para editar o borrar ejercicios individuales

    Route::get('/exercises/{exercise}/edit', [ExerciseController::class, 'edit'])->name('exercises.edit');
    Route::put('/exercises/{exercise}', [ExerciseController::class, 'update'])->name('exercises.update');
    Route::delete('/exercises/{exercise}', [ExerciseController::class, 'delete'])->name('exercises.delete');
});

require __DIR__ . '/auth.php';
