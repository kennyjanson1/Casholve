<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
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
