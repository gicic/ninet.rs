<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 31.12.2018.
 * Time: 09:23
 */

namespace App;


class Transliterator
{

    private static $srLatn = [
        'Đ','đ','Ž','ž','Ć','ć','Č','č','Š','š'
    ];

    private static $lat = [
        'Dj','dj','Z','z','C','c','C','c','S','s',
    ];

    public static function srToLat($sr)
    {
        return str_replace(self::$srLatn, self::$lat, $sr);
    }
    
}