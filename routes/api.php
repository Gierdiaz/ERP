<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Email\VerificationController;
use App\Http\Controllers\{CustomerController};
use Illuminate\Support\Facades\Route;

// Routes for registration and login using Passport
Route::middleware('guest')->group(function () {
    Route::post('register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
});

// Routes for email verification and email verification resend
Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('jsonplaceholder', [CustomerController::class, '__invoke']);

    // Rotas para visualizar clientes
    Route::get('customers', [CustomerController::class, 'index'])
        ->middleware('can:view customers')
        ->name('customers.index');

    Route::get('customers/{customer}', [CustomerController::class, 'show'])
        ->middleware('can:view customers')
        ->name('customers.show');

    // Rotas para criar clientes
    Route::post('customers', [CustomerController::class, 'store'])
        ->middleware('can:create customers')
        ->name('customers.store');

    // Rotas para atualizar clientes
    Route::put('customers/{customer}', [CustomerController::class, 'update'])
        ->middleware('can:update customers')
        ->name('customers.update');

    // Rotas para excluir clientes
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('can:delete customers')
        ->name('customers.destroy');

    // Rota para atribuir acesso a um usuário específico
    Route::post('users/{user}/assign-access', [CustomerController::class, 'assignAccess'])
        ->middleware('can:assignAccess,App\Models\Customer')
        ->name('users.assignAccess');

    // Rota para revogar acesso de um usuário específico
    Route::post('users/{user}/revoke-access', [CustomerController::class, 'revokeAccess'])
        ->middleware('can:revokeAccess,App\Models\Customer')
        ->name('users.revokeAccess');

    // Rota para revogar todos os acessos de um usuário específico
    Route::post('users/{user}/revoke-all-access', [CustomerController::class, 'revokeAllAccess'])
        ->middleware('can:revokeAccess,App\Models\Customer')
        ->name('users.revokeAllAccess');

});
