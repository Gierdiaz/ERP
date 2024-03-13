<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('login', [AuthenticationController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
});
