<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Email\VerificationController;
use Illuminate\Support\Facades\Route;

// Routes accessible only for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
});

// Routes for email verification and email verification resend
Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

// Routes for registration and login
Route::middleware('guest')->group(function () {
    Route::post('register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
});
