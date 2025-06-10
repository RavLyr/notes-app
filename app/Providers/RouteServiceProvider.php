<?php

namespace App\Providers;

use App\Models\Note;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::bind('note', function ($value) {
            return Note::withTrashed()->findOrFail($value);
        });
    }
}
