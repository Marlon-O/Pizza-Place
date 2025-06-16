<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->middleware('guest')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('inventory', function () {
        return Inertia::render('inventory/Index');
    })->name('inventory');

    Route::get('orders', function () {
        return Inertia::render('Orders');
    })->name('orders');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
