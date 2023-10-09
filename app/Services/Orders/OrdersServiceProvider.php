<?php


namespace App\Services\Orders;


use Illuminate\Support\ServiceProvider;

class OrdersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('orders', Orders::class);
    }
}