<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'category' => 'nullable|string|max:255',
            'difficulty_level' => 'required|string|in:fácil,medio,difícil',
        ]);

        $data['user_id'] = auth()->id();

        Exercise::create($data);

        return back()->with('success', 'Ejercicio creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'category' => 'nullable|string|max:255',
            'difficulty_level' => 'required|string|in:fácil,medio,difícil',
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

    public function showAll()
    {
        $exercises = auth()->user()->exercises;
        return view('exercises.show', compact('exercises'));
    }
}
