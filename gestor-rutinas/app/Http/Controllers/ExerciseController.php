<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\RoutineExercise;

class ExerciseController extends Controller
{
    public function new(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'category' => 'nullable|string|max:255',
            'difficulty_level' => 'nullable|string|max:255',
            'routine_id' => 'nullable|exists:routines,id',
            'reps' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'rest_time' => 'nullable|integer',
        ]);

        $exercise = new Exercise();
        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->video_url = $request->video_url;
        $exercise->category = $request->category;
        $exercise->difficulty_level = $request->difficulty_level;
        $exercise->user_id = auth()->user()->id;
        $exercise->is_template = false;
        $exercise->save();

        if ($request->routine_id) {
            RoutineExercise::create([
                'exercise_id' => $exercise->id,
                'routine_id' => $request->routine_id,
                'exercise_order' => 1, 
                'reps' => $request->reps,
                'duration' => $request->duration,
                'rest_time' => $request->rest_time,
            ]);
        }

        return back()->with('success', 'Ejercicio creado correctamente.');
    }

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

        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->video_url = $request->video_url;
        $exercise->category = $request->category;
        $exercise->difficulty_level = $request->difficulty_level;
        $exercise->save();

        return back()->with('success', 'Ejercicio actualizado correctamente.');
    }

    public function delete($id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->delete();

        return back()->with('success', 'Ejercicio eliminado correctamente.');
    }
}
