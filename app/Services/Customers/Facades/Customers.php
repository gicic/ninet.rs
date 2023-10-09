<?php


namespace App\Services\Customers\Facades;


use Illuminate\Support\Facades\Facade;

class Customers extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'customers';
    }
}