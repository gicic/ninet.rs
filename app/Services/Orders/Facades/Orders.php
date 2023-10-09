<?php


namespace App\Services\Orders\Facades;


use Illuminate\Support\Facades\Facade;

class Orders extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'orders';
    }
}