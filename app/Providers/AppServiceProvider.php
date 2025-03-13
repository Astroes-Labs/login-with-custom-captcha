<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
            return session('captcha') === $value; // Compare with the stored captcha
        });

        Validator::replacer('captcha', function ($message, $attribute, $rule, $parameters) {
            return 'The captcha is incorrect.';
        });
    }
}