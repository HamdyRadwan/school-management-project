<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function index()
    {
        return view('auth.selection');
    }

    public function dashboard()
    {
        // $x=Student::count();
        return view('dashboard');
    }
}
