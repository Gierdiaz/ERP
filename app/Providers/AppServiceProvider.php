<?php

namespace App\Providers;

use App\Http\Middleware\SetLocale;
use App\Interfaces\{CustomerInterface, EmployeeInterface, ProductInterface};
use App\Models\Customer;
use App\Policies\CustomerPolicy;
use App\Repositories\{CustomerRepository, EmployeeRepository, ProductRepository};
use Illuminate\Support\Facades\{Gate, Route};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //TODO: Register the CustomerRepository and bind it to the CustomerInterface interface
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
    }

    public function boot(): void
    {
        Route::pushMiddlewareToGroup('api', SetLocale::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
    }

}
