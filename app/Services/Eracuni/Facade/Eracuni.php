<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 15.10.2018.
 * Time: 10:35
 */

namespace App\Services\Eracuni\Facade;


use Illuminate\Support\Facades\Facade;

class Eracuni extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'eracuni';
    }
}