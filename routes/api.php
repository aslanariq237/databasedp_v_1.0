<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CustomerController,
    KeluhanController,
    TeknisiController,
    TandaterController,
    FinalController,
    UserController
};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Customer
Route::get('/customer', [CustomerController::class, 'index'])->name('data_customer');
Route::post('/reg-teknisi', [UserController::class, 'RegTek'])->name('regtek');
Route::post('/reg-admin', [UserController::class, 'Regadmin']);
Route::post('/reg-finance', [UserController::class, 'RegFin']);