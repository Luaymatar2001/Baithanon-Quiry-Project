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
        $household = \App\Models\household::with([
            'location',
            'partner',
            'children',
            'governorate',
            'city'
        ])->find($householdId);
        return view('details')->with('cities', $cities)->with('household', $household);
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

Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Marriage Requests (new feature)
Route::prefix('dashboard/marriage-requests')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', function () {
            return view('Dashboard.marriage-requests.index');
        })->name('marriage-requests.dashboard');
    });

Route::middleware(['verification'])->group(function () {
    Route::post('/marriage-requests', [\App\Http\Controllers\MarriageRequestController::class, 'store'])
        ->name('marriage-requests.store');
});


// Member Requests (new feature - isolated)
Route::prefix('dashboard/member-requests')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/pending', [\App\Http\Controllers\MemberRequestController::class, 'pending'])->name('member-requests.pending');
    Route::get('/accepted', [\App\Http\Controllers\MemberRequestController::class, 'accepted'])->name('member-requests.accepted');
    Route::get('/rejected', [\App\Http\Controllers\MemberRequestController::class, 'rejected'])->name('member-requests.rejected');

    Route::post('/{id}/accept', [\App\Http\Controllers\MemberRequestController::class, 'accept'])->name('member-requests.accept');
    Route::post('/{id}/reject', [\App\Http\Controllers\MemberRequestController::class, 'reject'])->name('member-requests.reject');
});

// Store requests from household details popup (new feature - isolated)
Route::middleware(['verification'])->group(function () {
    Route::post('/member-requests', [\App\Http\Controllers\MemberRequestController::class, 'store'])
        ->name('member-requests.store');
});


require __DIR__ . '/auth.php';
