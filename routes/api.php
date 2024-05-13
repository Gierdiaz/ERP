<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Email\VerificationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Routes for registration and login using Passport
Route::post('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('login', [AuthenticationController::class, 'login'])->name('login');

// Routes for email verification and email verification resend
Route::middleware('auth:api')->group(function () {
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

// Routes accessible only for authenticated users using Passport
Route::middleware('auth:api')->group(function () {
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});

Route::post('file', [ProfileController::class, 'file']);
Route::get('download/{file}', [ProfileController::class, 'download'])->name('file.download');
