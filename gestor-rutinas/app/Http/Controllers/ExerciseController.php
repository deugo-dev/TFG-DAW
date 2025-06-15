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

    //Servicio necesario para la creacion del ejercicio en las rutinas
    public function storeJson(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'category' => 'nullable|string|max:255',
            'difficulty_level' => 'required|string|in:fácil,medio,difícil',
        ]);

        $data['user_id'] = auth()->id();

        $exercise = Exercise::create($data);

        return response()->json([
            'message' => 'Ejercicio creado correctamente.',
            'exercise' => $exercise,
        ], 201);
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
        $user = auth()->user();

        $exercises = $user->exercises();

        if (session('filter_category')) {
            $exercises->where('category', session('filter_category'));
        }

        if (session('filter_difficulty')) {
            $exercises->where('difficulty_level', session('filter_difficulty'));
        }

        $exercises = $exercises->get();

        return view('exercises.show', compact('exercises'));
    }


    public function filtrar(Request $request)
    {
        session([
            'filter_category' => $request->category,
            'filter_difficulty' => $request->difficulty_level,
        ]);

        return back(); // Vuelve a 'exercises.show'
    }

    public function limpiar()
    {
        session()->forget(['filter_category', 'filter_difficulty']);
        return back(); // Vuelve a 'exercises.show'
    }
}
