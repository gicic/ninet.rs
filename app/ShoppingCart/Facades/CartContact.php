<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 16.8.2018.
 * Time: 13:44
 */

namespace App\ShoppingCart\Facades;


use Illuminate\Support\Facades\Facade;

class CartContact extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart-contact';
    }
}