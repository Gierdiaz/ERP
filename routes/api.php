<?php

use App\Classes\ApiResponse;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Email\VerificationController;
use App\Http\Controllers\{CustomerController, EmployeeController, ProductController};
use Illuminate\Support\Facades\Route;

// Routes accessible only for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // PRODUCTS ROUTES
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
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

Route::apiResource('employees', EmployeeController::class);