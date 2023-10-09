<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 12.7.2018.
 * Time: 09:55
 */

namespace App\ShoppingCart;


use Illuminate\Support\Collection;

class CartItemOptions extends Collection
{
    /**
     * Get the option by the given key.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
}