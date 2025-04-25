<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Share user data and locked status with all views if the user is authenticated
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $view->with('user', $user)
                     ->with('lockedStatus', $user->locked);
            }
        });
    }
}
