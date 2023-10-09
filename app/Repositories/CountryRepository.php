<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 2.10.2018.
 * Time: 13:25
 */

namespace App\Repositories;


use App\Models\Country;

class CountryRepository
{
    public static function getByCode($code)
    {
        return Country::where('code', $code)->first();
    }
}