<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 4.7.2018.
 * Time: 15:59
 */

namespace App\Repositories;


use App\Models\ProductCategory;

class ProductCategoryRepository
{

    public static function getCommonCategories()
    {
        // TODO: filter domains and ssl
        return ProductCategory::all();
    }

}