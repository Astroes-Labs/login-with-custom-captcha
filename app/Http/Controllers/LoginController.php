<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function validateLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ], [
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'captcha.required' => 'The captcha field is required.',
            'captcha.captcha' => 'The captcha is incorrect.',
        ]);

        // Sanitize inputs
        $sanitizedCredentials = [
            'email' => filter_var($credentials['email'], FILTER_SANITIZE_EMAIL),
            'password' => strip_tags($credentials['password'])
        ];

        // Remove captcha from credentials since it's not needed for authentication
        unset($credentials['captcha']);

        if (Auth::attempt($sanitizedCredentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Welcome back! You have been successfully logged in.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}