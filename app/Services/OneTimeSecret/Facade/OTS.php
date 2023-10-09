<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 4.9.2018.
 * Time: 12:58
 */

namespace App\Services\OneTimeSecret\Facade;


use Illuminate\Support\Facades\Facade;

class OTS extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'ots';
    }

}