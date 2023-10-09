<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 26.7.2018.
 * Time: 14:47
 */

namespace App\SocialNetworks\Facades;

use Illuminate\Support\Facades\Facade;

class Google extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'google';
    }
}