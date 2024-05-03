<?php

namespace App\Providers;

use App\Http\Middleware\SetLocale;
use App\Interfaces\{CustomerInterface};
use App\Models\{User};
use App\Observers\UserObserver;
use App\Repositories\{CustomerRepository};
use Illuminate\Support\Facades\{Route};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //TODO: Register the CustomerRepository and bind it to the CustomerInterface interface
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
    }

    public function boot(): void
    {
        Route::pushMiddlewareToGroup('api', SetLocale::class);
        User::observe(UserObserver::class);
    }

}
