<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        if (
            auth()->attempt([
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ])
            && in_array(
                auth()->user()->status,
                [User::STATUS['active'], User::STATUS['password_reset']]
            )
        ) {
            return redirect()->intended(route('home'));
        } else {
            auth()->logout();
            return back()->withErrors(['password' => 'Email or password is incorrect']);
        }
    }

    public function logout(Request $request) {
        auth()->logout();

        return $request->isXmlHttpRequest() ? response()->json([
            'status' => 'success',
            'redirect' => route('home'),
            'message' => 'You logged out successfully.'
        ]) : redirect()->route('home');
    }

    public function showLoginForm() {
        return view('auth.login');
    }
}