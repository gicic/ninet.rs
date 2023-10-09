<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 5.7.2018.
 * Time: 10:37
 */

namespace App\ShoppingCart\Facades;


use Illuminate\Support\Facades\Facade;

class ProductLineRepository extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'product_line_repository';
    }
}