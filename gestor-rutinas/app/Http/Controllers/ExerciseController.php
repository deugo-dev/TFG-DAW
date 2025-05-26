<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\RoutineExercise;

class ExerciseController extends Controller
{
    
    public function edit($id)
    {
        $exercise = Exercise::findOrFail($id);
        return view('exercises.edit', compact('exercise'));
    }

    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'category' => 'nullable|string|max:255',
            'difficulty_level' => 'nullable|string|max:255',
        ]);

        $exercise->update($request->only('title', 'description', 'video_url', 'category', 'difficulty_level'));

        return back()->with('success', 'Ejercicio actualizado correctamente.');
    }

    public function delete($id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->delete();

        return back()->with('success', 'Ejercicio eliminado correctamente.');
    }

}
