<?php

use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect root to login or appropriate dashboard
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'attendant') {
            return redirect()->route('pos.index');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Require authentication for all routes inside this group
Route::middleware(['auth'])->group(function () {
    
    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('accessories', AccessoryController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
        Route::get('/sales/{sale}', [SalesController::class, 'show'])->name('sales.show');
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
        Route::post('/reports/generate', [DashboardController::class, 'generateReport'])->name('reports.generate');
    });

    // POS - accessible to all authenticated users (both admin and attendant)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/add', [PosController::class, 'addItem'])->name('pos.add');
    Route::post('/pos/remove', [PosController::class, 'removeItem'])->name('pos.remove');
    Route::post('/pos/update', [PosController::class, 'updateQuantity'])->name('pos.update');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
    Route::get('/pos/receipt/{sale}', [PosController::class, 'receipt'])->name('pos.receipt');
    Route::get('/pos/cart', [PosController::class, 'getCart'])->name('pos.cart');
});

require __DIR__.'/auth.php';