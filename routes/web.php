<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TransactionsInstallmentsController;
use App\Http\Controllers\VaultsController;

//Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//Home Routes
Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');

    Route::resource('transactions', TransactionsController::class)->names('transactions');
    Route::get('transactions/status/{id}', [TransactionsController::class, 'status'])->name('transactions.status');

    Route::resource('transactions/installments', TransactionsInstallmentsController::class)->names('transactions.installments');

    Route::resource('vaults', VaultsController::class)->names('vaults');
});
