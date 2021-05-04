<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    function index() {
        $user = Auth::user();
        return view('/tasks');
    }
}
