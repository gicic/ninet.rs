<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.12.2018.
 * Time: 15:55
 */

namespace App\Services\CoreAPI\Facades;


use Illuminate\Support\Facades\Facade;

class ExternalResource extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'external-resource';
    }

}