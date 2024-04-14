<?php

namespace App\Providers;

use App\Http\Middleware\SetLocale;
use App\Interfaces\CustomerInterface;
use App\Interfaces\ProductInterface;
use App\Models\Customer;
use App\Policies\CustomerPolicy;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //TODO: Register the CustomerRepository and bind it to the CustomerInterface interface
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::pushMiddlewareToGroup('api', SetLocale::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
    }

    

}
