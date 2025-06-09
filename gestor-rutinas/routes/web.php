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

    // Rutas de rutinas
    Route::get('/routines', [RoutineController::class, 'index'])->name('routines.index');
    Route::get('/routines/new', [RoutineController::class, 'new'])->name('routines.new');
    Route::post('/routines/store', [RoutineController::class, 'store'])->name('routines.store');
    Route::get('/routines/{routine}', [RoutineController::class, 'show'])->name('routines.show');
    Route::get('/routines/{routine}/edit', [RoutineController::class, 'edit'])->name('routines.edit');
    Route::put('/routines/{routine}', [RoutineController::class, 'update'])->name('routines.update');
    Route::delete('/routines/{routine}', [RoutineController::class, 'delete'])->name('routines.delete');

    // Asociar o desasociar ejercicios a una rutina
    Route::prefix('/routines/{routine}/exercises')->group(function () {
        Route::post('/', [RoutineExerciseController::class, 'attach'])->name('routine_exercises.attach');
        Route::put('/{exercise}', [RoutineExerciseController::class, 'update'])->name('routine_exercises.update');
        Route::delete('/{exercise}', [RoutineExerciseController::class, 'delete'])->name('routine_exercises.delete');
    });
    Route::post('/routines/{routine}/exercises/reorder', [RoutineExerciseController::class, 'reorder'])
        ->name('routine_exercises.reorder');



    // Rutas de ejercicios
    Route::post('/exercises/store', [ExerciseController::class, 'store'])->name('exercises.store');
    Route::put('/exercises/{exercise}', [ExerciseController::class, 'update'])->name('exercises.update');
    Route::delete('/exercises/{exercise}', [ExerciseController::class, 'delete'])->name('exercises.delete');
    Route::get('/mis-ejercicios', [ExerciseController::class, 'showAll'])->name('exercises.showAll');
});

require __DIR__ . '/auth.php';
