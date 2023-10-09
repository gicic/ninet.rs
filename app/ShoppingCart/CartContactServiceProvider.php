<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 16.8.2018.
 * Time: 13:45
 */

namespace App\ShoppingCart;


use Illuminate\Support\ServiceProvider;

class CartContactServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('cart-contact', CartContact::class);
    }

}