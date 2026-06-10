<?php

namespace App\Providers;

use App\Models\head_children;
use App\Models\partner;
use Illuminate\Support\Facades\Validator;
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
        Validator::extend('exists_in_two_tables', function ($attribute, $value) {
            return
                head_children::where('id', $value)->exists()
                || partner::where('id', $value)->exists();
        });
    }
}
