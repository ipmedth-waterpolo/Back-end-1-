<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Training;
use App\Models\Oefening;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function chooseOption()
    {
        return view('admin.choose');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function trainings()
    {
        $trainings = Training::all();
        return view('admin.trainings', compact('trainings'));
    }

    public function exercises()
    {
        $exercises = Oefening::all();
        return view('admin.exercises', compact('exercises'));
    }
}
