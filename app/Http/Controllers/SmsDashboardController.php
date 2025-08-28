<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}

