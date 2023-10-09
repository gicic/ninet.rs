<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 4.10.2018.
 * Time: 13:15
 */

namespace App;


class CommonFunctions
{
    /**
     * Vracanje pocetnog karaktera za prosledjeni string
     *
     * @param string $string
     * @return string
     */
    public static function getInitial($string) {
        $string = str_replace('Đ', 'dj', $string);
        $string = str_replace('đ', 'dj', $string);
        $string = str_replace('Ž', 'z', $string);
        $string = str_replace('ž', 'z', $string);
        $string = str_replace('Ć', 'c', $string);
        $string = str_replace('ć', 'c', $string);
        $string = str_replace('Č', 'c', $string);
        $string = str_replace('č', 'c', $string);
        $string = str_replace('Š', 's', $string);
        $string = str_replace('š', 's', $string);
        $string = str_replace('Å ', 's', $string);
        $string = str_replace('Å¡', 's', $string);
        $string = str_replace('Ä', 'dj', $string);
        $string = str_replace('Ä‘', 'dj', $string);
        $string = str_replace('Å½', 'z', $string);
        $string = str_replace('Å¾', 'z', $string);
        $string = str_replace('ÄŒ', 'c', $string);
        $string = str_replace('Ä', 'c', $string);
        $string = str_replace('Ä†', 'c', $string);
        $string = str_replace('Ä‡', 'c', $string);

        $string = str_replace('-', '', $string);
        $string = strtolower($string);

        return substr($string, 0, 1);
    }

    public static function priceFormat($price)
    {
        if(\App::getLocale() === 'sr-Latn') {
            return number_format($price, 2, ',', '.');
        }
        return number_format($price, 2, '.', ',');
    }
}