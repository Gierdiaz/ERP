<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{Exceptions, Middleware};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->alias([
        //     'role' =>  \Spatie\Permission\Middleware\RoleMiddleware::class,
        //     //'role' =>  \App\Models\Role::class, //TODO: Observação caso o role de cima não funciona por causa da mudança no arquivo permission.php
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
