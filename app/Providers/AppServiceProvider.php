<?php

namespace App\Providers;

use App\Http\Middleware\SetLocale;
use App\Interfaces\{CustomerInterface};
use App\Models\{Customer, User};
use App\Observers\UserObserver;
use App\Policies\CustomerPolicy;
use App\Repositories\{CustomerRepository};
use Illuminate\Support\Facades\{Gate, Route};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Customer::class => CustomerPolicy::class,
    ];

    public function register(): void
    {
        //TODO: Register the CustomerRepository and bind it to the CustomerInterface interface
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
    }

    public function boot(): void
    {
        Route::pushMiddlewareToGroup('api', SetLocale::class);
        User::observe(UserObserver::class);

        Gate::resource('customer', CustomerPolicy::class);
    }

}
