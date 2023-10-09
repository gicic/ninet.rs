<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 22.12.2018.
 * Time: 13:10
 */

namespace App\Repositories;


use App\Models\Discount;
use App\Models\DiscountType;

class DiscountRepository
{

    public static function promoCodeExists($promoCode)
    {
        $result = Discount::where('code', $promoCode)
            ->whereRaw('valid_from <= CURDATE()')
            ->whereRaw('valid_to >= CURDATE()')
            ->first();

        return !empty($result);
    }

    public static function getPromoCodeCollection($promoCode)
    {

        $promoCodeType = DiscountType::where('code', 'promo_code')->first();

        $result = Discount::where('code', $promoCode)
            ->where('discount_type_id', $promoCodeType->id)
            ->with('products')
            ->first();

        return $result;
    }

}