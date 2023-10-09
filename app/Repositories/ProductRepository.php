<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 4.7.2018.
 * Time: 14:52
 */

namespace App\Repositories;


use App\Models\Product;
use App\Models\ProductCategory;

class ProductRepository
{

    /**
     * @param $id
     * @return mixed
     */
    public static function getByProductLine($id)
    {
        return Product::where('product_line_id', $id)->where('active', 1)->where('public', 1)->get();
    }

    /**
     * Domain products
     *
     * @return mixed
     */
    public static function getDomainProducts()
    {
        return Product::join('product_lines', 'product.product_line_id', '=', 'product_line.id')
            ->join('product_category', 'product_line.product_category_id', '=', 'product_category.id')
            ->where('product_category.code', 'domains')
            ->get();
    }

    /**
     * All domain products with extensions and vendors
     *
     * @return mixed
     */
    public static function getAllDomains()
    {
        $category = ProductCategory::where('code', 'domains')->first();
        return Product::select('products.*', 'domain_extensions.registration_price_resident', 'domain_extensions.registration_price_foreign')
            ->join('domain_extensions', 'products.id', '=', 'domain_extensions.product_id')
            ->whereIn('products.product_line_id', $category->productLines()->pluck('id')->toArray())
            ->where('products.active', 1)->where('products.public', 1)
            ->with('domainExtension.registrationVendor')
            ->get();
    }
    
}