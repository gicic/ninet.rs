<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 18.10.2018.
 * Time: 09:34
 */

namespace App\Services\Resello\Facades;


use Illuminate\Support\Facades\Facade;

class Resello extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'resello';
    }

}