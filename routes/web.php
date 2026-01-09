<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\HeadHouseController as DashboardHeadHouseController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\UserController;
use App\Models\city;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', function () {
    return view('app');
});

Route::middleware(['verification'])->group(function () {
    Route::get('/details', function () {
        $cities = city::select('id', 'name')->get();
        
        $householdId = session('household_verified');
        if (!$householdId) {
            abort(403, 'Unauthorized');
        }
        $household = \App\Models\household::with('location')->find($householdId);
        return view('details')->with('cities', $cities )->with('household', $household);
    })->name('details');
    Route::patch('/submit-details', [HouseholdController::class, 'updateDetails'])->name('submit-details');
    // Delete 

    Route::post('/addRow', [HouseholdController::class, 'addRowMember'])->name('addRowMember');
    Route::put('/updateRowMember', [HouseholdController::class, 'updateRowMember'])->name('updateRowMember');


    Route::delete('/member/{id}', [HouseholdController::class, 'destroy'])->name('member.destroy');
    Route::get('/logout', function () {
        session()->flush();
        return redirect('/');
    })->name('logout');
        
    });

Route::view('/welcome', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

  

require __DIR__.'/auth.php';
