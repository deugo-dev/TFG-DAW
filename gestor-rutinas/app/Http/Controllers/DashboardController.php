<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;

class DashboardController extends Controller
{
    public function index()
    {
        $routines = Routine::where('user_id', auth()->id())->get();
        return view('dashboard', compact('routines'));
    }
}
