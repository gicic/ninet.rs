<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 22.10.2018.
 * Time: 10:03
 */

namespace App\Services\Domains\Facades;


use Illuminate\Support\Facades\Facade;

class Domains extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'domains';
    }
}