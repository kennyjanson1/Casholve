<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SavingsPlanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SavingsTransactionController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Login & Register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    /*
    |--------------------------------------------------------------------------
    | Account Management
    |--------------------------------------------------------------------------
    */
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
    
    /*
    |--------------------------------------------------------------------------
    | Dashboard (Main Page with Analytics)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    /*
    |--------------------------------------------------------------------------
    | Transactions Management
    |--------------------------------------------------------------------------
    */
    // Main transaction routes (CRUD)
    Route::resource('transactions', TransactionController::class);
    
    // Soft delete features
    Route::get('transactions/trash/list', [TransactionController::class, 'trash'])->name('transactions.trash');
    Route::post('transactions/{id}/restore', [TransactionController::class, 'restore'])->name('transactions.restore');
    
    // Keep your old transaction view if needed
    Route::get('/transaction', function () {
        return redirect()->route('transactions.index');
    })->name('transaction');
    
    /*
    |--------------------------------------------------------------------------
    | Categories Management
    |--------------------------------------------------------------------------
    */
    Route::resource('categories', CategoryController::class)->except(['show']);
    
    /*
    |--------------------------------------------------------------------------
    | Cashflow View
    |--------------------------------------------------------------------------
    */
    Route::get('/cashflow', function () {
        return view('cashflow');
    })->name('cashflow');
    
    /*
    |--------------------------------------------------------------------------
    | Savings Plans / Goals Management
    |--------------------------------------------------------------------------
    */
    // Main savings plan routes (CRUD)
    Route::resource('savings', SavingsPlanController::class);
    
    // Additional actions
    Route::post('savings/{savingsPlan}/complete', [SavingsPlanController::class, 'complete'])->name('savings.complete');
    Route::post('savings/{savingsPlan}/cancel', [SavingsPlanController::class, 'cancel'])->name('savings.cancel');
    
    // Savings Transactions (deposit/withdraw)
    Route::post('savings/{savingsPlan}/transactions', [SavingsTransactionController::class, 'store'])->name('savings.transactions.store');
    Route::delete('savings-transactions/{savingsTransaction}', [SavingsTransactionController::class, 'destroy'])->name('savings.transactions.destroy');
    
    // Keep your old goals view if needed (redirect to savings)
    Route::get('/goals', function () {
        return redirect()->route('savings.index');
    })->name('goals');
});