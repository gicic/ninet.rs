<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 17.10.2018.
 * Time: 09:19
 */

namespace App\Services\GoDaddy\Facades;


use Illuminate\Support\Facades\Facade;

class GoDaddyDomain extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'godaddy-domain';
    }
}