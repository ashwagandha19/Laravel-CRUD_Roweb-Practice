<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoardsController extends Controller
{
    function index() {
        $user = Auth::user();
        return view('/boards');
    }
}
