<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 7.8.2018.
 * Time: 09:50
 */

namespace App\Solus\Facade;


use Illuminate\Support\Facades\Facade;

class Solus extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'solus';
    }

}