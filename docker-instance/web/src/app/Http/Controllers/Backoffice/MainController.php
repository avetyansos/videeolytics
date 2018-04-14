<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function index() {
        return view('backoffice.main.dashboard');
    }

    public function test() {
        return view('backoffice.main.dashboard');
    }
}