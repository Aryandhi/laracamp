<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('welcome');



// socialite route
Route::get('sign-in-google', [UserController::class, 'google'])->name('user.login.google');
Route::get('auth/google/callback', [UserController::class, 'handleProviderCallback'])->name('user.google.callback');



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //checkout routes
    Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/{camps:slug}', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('checkout/{camps}', [CheckoutController::class, 'store'])->name('checkout.store');

    //dashboard
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // user dashboard - grouping route
    Route::prefix('user/dashboard')->namespace('User')->name('user.')->group(function() {
        Route::get('/', [UserDashboard::class, 'index'])->name('dashboard');
    });

    // admin dashboard - grouping route
    Route::prefix('admin/dashboard')->namespace('Admin')->name('admin.')->group(function() {
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    });
});

require __DIR__.'/auth.php';
