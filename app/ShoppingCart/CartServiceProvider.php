<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 3.7.2018.
 * Time: 14:21
 */

namespace App\ShoppingCart;


use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('cart', 'App\ShoppingCart\Cart');

        $config = __DIR__ . '/../../config/cart.php';
        $this->mergeConfigFrom($config, 'cart');
    }
    
}