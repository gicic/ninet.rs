<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 4.7.2018.
 * Time: 14:08
 */

namespace App\Repositories;


use App\Models\ProductLine;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class ProductLineRepository
{

    /**
     * Get all paths for Product Lines
     *
     * @return mixed
     */
    public static function getCommonPaths()
    {
        // TODO: filtrirati domene i SSL

        $plines = ProductLine::all();
        $paths = [];
        foreach ($plines as $pline) {
            $paths[] = $pline->public_path;
        }

        return $paths;
    }

    /**
     * Get product lines for common products
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getForCommonProducts()
    {
        // TODO: filtrirati domene i SSL

        return ProductLine::all();
    }

    /**
     * Get product line by public path
     *
     * @param $public_path
     * @return mixed
     */
    public static function getByPublicPath($public_path)
    {
        return ProductLine::where('public_path', 'like', '%' . $public_path . '%')->firstOrFail();
    }

    public static function getCategoryPaths($id)
    {
        $lines = ProductLine::where('product_category_id', $id)->get();
        $paths = [];
        foreach ($lines as $line) {
            $paths[] = $line->public_path;
        }
        return $paths;
    }

    /**
     * @param $code
     * @return ProductLine|\Illuminate\Database\Eloquent\Model|null|object
     */
    public static function getByCode($code)
    {
        return ProductLine::where('code', $code)->firstOrFail();
    }

}