<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Guest routes (login & register)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes (need authentication)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Di dalam Route::middleware('auth')->group(function () {
    Route::put('/account/update', [AuthController::class, 'updateProfile'])->name('account.update');
    
    // Dashboard route (NEW)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/account', function () {
        return view('account');
    })->name('account');

    Route::get('/transaction', function () {
        return view('transaction');
    })->name('transaction');

    Route::get('/cashflow', function () {
        return view('cashflow');
    })->name('cashflow');

    Route::get('/goals', function () {
        return view('goals');
    })->name('goals');
});