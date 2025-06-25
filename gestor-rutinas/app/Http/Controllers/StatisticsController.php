<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Routine;
use App\Models\Exercise;

class StatisticsController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $routinesCount = Routine::count();
        $exercisesCount = Exercise::count();

        return view('statistics.index', compact('usersCount', 'routinesCount', 'exercisesCount'));
    }
}
