<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Email\VerificationController;
use App\Http\Controllers\{CustomerController, UserController};
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

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('jsonplaceholder', [CustomerController::class, '__invoke']);

    // Rotas para visualizar clientes
    Route::get('customers/{id}', [CustomerController::class, 'index'])
        ->middleware('can:view,App\Models\Customer')
        ->name('customers.index');

    Route::get('customers/{customer}', [CustomerController::class, 'show'])
        ->middleware('can:view,App\Models\Customer')
        ->name('customers.show');

    // Rotas para criar clientes
    Route::post('customers', [CustomerController::class, 'store'])
        ->middleware('can:create,App\Models\Customer')
        ->name('customers.store');

    // Rotas para atualizar clientes
    Route::put('customers/{customer}', [CustomerController::class, 'update'])
        ->middleware('can:update,App\Models\Customer')
        ->name('customers.update');

    // Rotas para excluir clientes
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('can:delete,App\Models\Customer')
        ->name('customers.destroy');

    // Rota para atribuir acesso a um usuário específico
    Route::post('users/{user}/assign-access', [UserController::class, 'assignAccess'])
        ->middleware('can:assignAccess,App\Models\User')
        ->name('users.assignAccess');

    // Rota para revogar acesso de um usuário específico
    Route::post('users/{user}/revoke-access', [UserController::class, 'revokeAccess'])
        ->middleware('can:revokeAccess,App\Models\User')
        ->name('users.revokeAccess');

    // Rota para revogar todos os acessos de um usuário específico
    Route::post('users/{user}/revoke-all-access', [UserController::class, 'revokeAllAccess'])
        ->middleware('can:revokeAllAccess,App\Models\User')
        ->name('users.revokeAllAccess');

    // Rota para listar usuários
    Route::get('users', [UserController::class, 'index'])
        ->middleware('can:view users')
        ->name('users.index');

    // Rota para exibir um único usuário
    Route::get('users/{user}', [UserController::class, 'show'])
        ->middleware('can:view users')
        ->name('users.show');

    // Rota para criar um novo usuário
    Route::post('users', [UserController::class, 'store'])
        ->middleware('can:create users')
        ->name('users.store');

    // Rota para atualizar um usuário existente
    Route::put('users/{user}', [UserController::class, 'update'])
        ->middleware('can:update users')
        ->name('users.update');

    // Rota para excluir um usuário
    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->middleware('can:delete users')
        ->name('users.destroy');

    // Rota para atribuir uma role a um usuário específico
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])
        ->middleware('can:assign roles')
        ->name('users.assignRole');

    // Rota para remover uma role de um usuário específico
    Route::post('users/{user}/remove-role', [UserController::class, 'removeRole'])
        ->middleware('can:remove roles')
        ->name('users.removeRole');

    // Rota para verificar se o usuário é admin
    Route::get('users/some-method', [UserController::class, 'someMethod'])
        ->middleware('can:view users')
        ->name('users.someMethod');
});
