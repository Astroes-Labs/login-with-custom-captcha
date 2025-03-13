<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function generateCaptcha()
    {
        // Generate a random string for the captcha
        $randomString = substr(md5(mt_rand()), 0, 6); // 6-character random string
        Session::put('captcha', $randomString); // Store the captcha in the session

        // Log the captcha for debugging
        \Log::info('Generated Captcha:', ['captcha' => $randomString]);

        // Return the captcha as JSON
        return response()->json(['captcha' => $randomString]);
    }
}