<?php

namespace App\Http\Controllers;

class HomeController
{
    public function index() {
        return redirect()->route(auth()->guest() ? 'login' : 'backoffice');
        // return view('home.welcome');
    }
}