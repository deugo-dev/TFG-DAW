<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoutineExerciseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatisticsController;




Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    //Gestion de usuarios  

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    //Estadisticas
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    // Dashboard y perfil
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/remove-picture', [ProfileController::class, 'removePicture'])->name('profile.removePicture');
    Route::delete('/profile', [ProfileController::class, 'delete'])->name('profile.delete');

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
    Route::post('/exercises/json', [ExerciseController::class, 'storeJson'])->name('exercises.storeJson');
    Route::put('/exercises/{exercise}', [ExerciseController::class, 'update'])->name('exercises.update');
    Route::delete('/exercises/{exercise}', [ExerciseController::class, 'delete'])->name('exercises.delete');
    Route::get('/mis-ejercicios', [ExerciseController::class, 'showAll'])->name('exercises.showAll');
    Route::get('/exercises/filter', [ExerciseController::class, 'filtrar'])->name('exercises.filter');
    Route::get('/exercises/clear', [ExerciseController::class, 'limpiar'])->name('exercises.clearFilters');
});

require __DIR__ . '/auth.php';
