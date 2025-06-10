<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\Exercise;

class RoutineExerciseController extends Controller
{
    public function attach(Request $request, Routine $routine)
    {
        $validated = $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'reps' => 'nullable|integer|min:1',
            'sets' => 'nullable|integer|min:1',
            'duration' => 'nullable|integer|min:1',
            'rest_time' => 'nullable|integer|min:1',
        ]);

        // Obtener el siguiente orden
        $nextOrder = $routine->exercises()->max('exercise_order') + 1 ?? 1;

        $routine->exercises()->attach($validated['exercise_id'], [
            'exercise_order' => $nextOrder,
            'reps' => $validated['reps'],
            'sets' => $validated['sets'],
            'duration' => $validated['duration'],
            'rest_time' => $validated['rest_time'],
        ]);

        return redirect()->back()->with('success', 'Ejercicio añadido a la rutina.');
    }


    public function update(Request $request, Routine $routine, Exercise $exercise)
    {
        $validated = $request->validate([
            'exercise_order' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'sets' => 'nullable|integer|min:1',
            'duration' => 'nullable|integer|min:1',
            'rest_time' => 'nullable|integer|min:0',
        ]);

        $routine->exercises()->updateExistingPivot($exercise->id, $validated);

        return redirect()->route('routines.show', $routine)->with('success', 'Ejercicio actualizado correctamente');
    }

    public function delete(Routine $routine, Exercise $exercise)
    {
        $routine->exercises()->detach($exercise->id);

        return redirect()->route('routines.show', $routine)->with('success', 'Ejercicio eliminado de la rutina');
    }

    public function reorder(Request $request, Routine $routine)
    {
        $order = $request->input('order');

        foreach ($order as $index => $exerciseId) {
            $routine->exercises()->updateExistingPivot($exerciseId, [
                'exercise_order' => $index + 1,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
