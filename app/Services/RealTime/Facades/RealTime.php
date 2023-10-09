<?php


namespace App\Services\RealTime\Facades;


use Illuminate\Support\Facades\Facade;

class RealTime extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'realtime';
    }
}