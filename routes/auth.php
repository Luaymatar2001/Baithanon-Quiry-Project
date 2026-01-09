<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\HeadHouseController as DashboardHeadHouseController;
use App\Http\Controllers\UserController;
use Livewire\Volt\Volt;

Route::prefix('admin')->as('admin.')->middleware('guest')->group(function () {
    // Volt::route('register', 'pages.auth.register')
    //     ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    // Volt::route('forgot-password', 'pages.auth.forgot-password')
    //     ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/login');
    })->name('admin.logout');

    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

        
    Route::resource('dashboard/headhousehold', DashboardHeadHouseController::class);
    
    Route::delete('/users/bulk-delete', [UserController::class, 'bulkDelete'])
            ->name('users.bulkDelete');
    Route::put('/users/{user}/password', [UserController::class, 'updatePassword']);

    Route::resource('users', UserController::class);

});
