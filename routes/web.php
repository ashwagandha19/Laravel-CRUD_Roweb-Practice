<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])->name('register');

//*EMAIL ROUTES
Route::get('/verify-email', [AuthController::class, 'verifyNotice'])->middleware('auth')->name('verification.notice');
Route::get('verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('resend-verify-email', [AuthController::class, 'resendVerifyEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//*END EMAIL ROUTES

//*PASSWORD RESET ROUTES
Route::match(['get', 'post'], '/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::match(['get', 'post'], '/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
//*END PASSWORD RESET ROUTES


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'boards'])->name('dashboard');

    Route::middleware(['admin'])->group(function () {
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users.all');
    });
});

Route::get('/user/edit/{id}', [AdminController::class, 'edit'])->name('user.edit');
Route::post('/user/update/{id}', [AdminController::class, 'update'])->name('user.update');
Route::post('/user/delete/{id}', [AdminController::class, 'destroy'])->name('user.destroy');