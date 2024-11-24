<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    // Method to display the index page (accessible to everyone)
    public function index()
    {
        return view('index');
    }
}
