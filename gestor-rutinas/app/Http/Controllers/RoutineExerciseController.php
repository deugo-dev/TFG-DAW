<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\Exercise;
use Illuminate\Http\Request;

class RoutineExerciseController extends Controller
{
    public function store(Request $request, Routine $routine)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'category' => 'nullable|string|max:255',
            'difficulty_level' => 'required|string|in:easy,medium,hard',
            'exercise_order' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:0',
            'duration' => 'nullable|integer|min:0',
            'rest_time' => 'nullable|integer|min:0',
        ]);

        $exercise = Exercise::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'category' => $data['category'] ?? null,
            'difficulty_level' => $data['difficulty_level'],
            'user_id' => auth()->id(),
        ]);

        $routine->exercises()->attach($exercise->id, [
            'exercise_order' => $data['exercise_order'] ?? ($routine->exercises()->count() + 1),
            'reps' => $data['reps'] ?? null,
            'duration' => $data['duration'] ?? null,
            'rest_time' => $data['rest_time'] ?? null,
        ]);

        return redirect()->route('routines.show', $routine->id)->with('success', 'Ejercicio añadido correctamente.');
    }


    public function update(Request $request, Routine $routine, Exercise $exercise)
    {
        $data = $request->validate([
            'exercise_order' => 'nullable|integer',
            'reps' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'rest_time' => 'nullable|integer',
        ]);

        $routine->exercises()->updateExistingPivot($exercise->id, [
            'exercise_order' => $data['exercise_order'] ?? 1,
            'reps' => $data['reps'] ?? null,
            'duration' => $data['duration'] ?? null,
            'rest_time' => $data['rest_time'] ?? null,
        ]);

        return redirect()->route('routines.show', $routine->id)->with('success', 'Datos del ejercicio actualizados.');
    }

    public function delete(Routine $routine, Exercise $exercise)
    {
        $routine->exercises()->detach($exercise->id);

        return redirect()->route('routines.show', $routine->id)->with('success', 'Ejercicio eliminado de la rutina.');
    }
}
