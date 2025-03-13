<?php

use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use Intervention\Image\Facades\Image;

Route::get('/', function () {
    return view('index');
});

Route::get('/captcha', [CaptchaController::class, 'generateCaptcha'])->name('captcha');

Route::post('/login', [LoginController::class, 'validateLogin'])->name('login');