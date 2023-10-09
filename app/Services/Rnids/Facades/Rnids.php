<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 17.10.2018.
 * Time: 11:45
 */

namespace App\Services\Rnids\Facades;


use Illuminate\Support\Facades\Facade;

class Rnids extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'rnids';
    }

}