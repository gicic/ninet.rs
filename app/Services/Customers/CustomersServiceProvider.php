<?php


namespace App\Services\Customers;


use Illuminate\Support\ServiceProvider;

class CustomersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('customers', Customers::class);
    }
}