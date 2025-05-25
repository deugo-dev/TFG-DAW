<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;

class RoutineController extends Controller
{
    public function index()
    {
        $routines = Routine::where('user_id', auth()->id())->get();
        return view('routines.index', compact('routines'));
    }

    public function new()
    {
        return view('routines.create'); 
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $validatedData['is_template'] = $request->has('is_template'); // checkbox
    
        // Aquí asignamos el id del usuario autenticado
        $validatedData['user_id'] = auth()->id();
    
        Routine::create($validatedData);
    
        return redirect()->route('dashboard')->with('success', 'Rutina creada correctamente');
    }



    public function edit($id)
    {
        $routine = Routine::findOrFail($id);
        return view('routines.edit', compact('routine'));
    }

    public function update(Request $request, $id)
    {
        $routine = Routine::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_template' => 'nullable|boolean',
        ]);

        $routine->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_template' => $request->is_template ?? false,
        ]);

        return back()->with('success', 'Rutina actualizada correctamente.');
    }

    public function delete($id)
    {
        $routine = Routine::findOrFail($id);
        $routine->delete();

        return back()->with('success', 'Rutina eliminada correctamente.');
    }

    public function show($id)
    {
        $routine = Routine::findOrFail($id);
        return view('routines.show', compact('routine'));
    }
}
