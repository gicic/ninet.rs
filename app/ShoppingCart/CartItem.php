<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 3.7.2018.
 * Time: 16:12
 */

namespace App\ShoppingCart;


class CartItem
{
    /**
     * The rowID of the cart item.
     *
     * @var string
     */
    public $rowId;
    /**
     * The ID of the cart item.
     *
     * @var int|string
     */
    public $id;
    /**
     * The quantity for this cart item.
     *
     * @var int|float
     */
    public $qty;
    /**
     * The name of the cart item.
     *
     * @var string
     */
    public $name;
    /**
     * The price without TAX of the cart item.
     *
     * @var float
     */
    public $price;
    /**
     * The period of the cart item.
     *
     * @var float
     */
    public $period;
    /**
     * The terms of the cart item.
     *
     * @var bool
     */
    public $terms = false;
    /**
     * The price without TAX of the cart item.
     *
     * @var float
     */
    public $parentRowId;
    /**
     * The tax rate for the cart item.
     *
     * @var int|float
     */
    private $taxRate = 0;

    /**
     * The discounts for the cart item
     *
     * @var array
     */
    public $discounts = [];

    /**
     * The discounts with fixed amount
     *
     * @var array
     */
    public $discountAmounts = [];

    /**
     * @var array
     */
    public $options;

    /**
     * @var string
     */
    public $period_text;

    /**
     * Product category name
     *
     * @var null|string
     */
    public $category;

    /**
     * Period multiplier
     *
     * @var int|null
     */
    public $periodMultiplier;

    /**
     * CartItem constructor.
     *
     * @param $id
     * @param $name
     * @param $price
     * @param $period
     * @param $terms
     * @param $parentRowId
     * @param array $discounts
     * @param array $discountAmounts
     * @param array $options
     * @param string $period_text
     * @param null $category
     * @param null $periodMultiplier
     */
    public function __construct($id, $name, $price, $period, $terms, $parentRowId, array $discounts = [], array $discountAmounts = [], array $options = [], $period_text = 'm', $category = null, $periodMultiplier = null)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Please supply a valid identifier.');
        }
        if (empty($name)) {
            throw new \InvalidArgumentException('Please supply a valid name.');
        }
        if (strlen($price) < 0 || !is_numeric($price)) {
            throw new \InvalidArgumentException('Please supply a valid price.');
        }
        if (empty($period)) {
            throw new \InvalidArgumentException('Please supply a valid period.');
        }
        $this->id = $id;
        $this->name = $name;
        $this->price = floatval($price);
        $this->period = intval($period);
        $this->terms = intval($terms);
        $this->rowId = $this->generateRowId($id, $parentRowId);
        $this->discounts = $discounts;
        $this->discountAmounts = $discountAmounts;
        $this->options  = new CartItemOptions($options);
        $this->parentRowId = $parentRowId;
        $this->period_text = $period_text;
        $this->category = $category;
        $this->periodMultiplier = $periodMultiplier;
    }

    /**
     * @param $id
     * @param $parentRowId
     * @return string
     */
    protected function generateRowId($id, $parentRowId)
    {
        return md5($id . (isset($parentRowId) ? $parentRowId : time()));
    }

    /**
     * @param array $attributes
     * @return CartItem
     */
    public static function createItem(array $attributes)
    {
        $options = array_get($attributes, 'options', []);
        $discounts = array_get($attributes, 'discounts', []);
        $discountAmounts = array_get($attributes, 'discountAmounts', []);
        $terms = array_get($attributes, 'terms', []);
        $parentRowId = array_get($attributes, 'parentRowId', null);
        $period_text = array_get($attributes, 'period_text', 'm');
        $category = array_get($attributes, 'category', null);
        $periodMultiplier = array_get($attributes, 'periodMultiplier', null);
        return new self($attributes['id'], $attributes['name'], $attributes['price'], $attributes['period'], $terms, $parentRowId, $discounts, $discountAmounts, $options, $period_text, $category, $periodMultiplier);
    }

    /**
     * @param array $attributes
     */
    public function updateItem(array $attributes)
    {
        $this->id = array_get($attributes, 'id', $this->id);
        $this->qty = array_get($attributes, 'qty', $this->qty);
        $this->name = array_get($attributes, 'name', $this->name);
        $this->price = array_get($attributes, 'price', $this->price);
        $this->period = array_get($attributes, 'period', $this->period);
        $this->terms = filter_var(array_get($attributes, 'terms', $this->terms), FILTER_VALIDATE_BOOLEAN);
        $this->parentRowId = array_get($attributes, 'parentRowId', $this->parentRowId);
        $this->discounts = array_get($attributes, 'discounts', $this->discounts);
        $this->discountAmounts = array_get($attributes, 'discountAmounts', $this->discountAmounts);
        $this->periodMultiplier = array_get($attributes, 'periodMultiplier', $this->periodMultiplier);
        if( ! empty($attributes['options'])) {
            $this->addOptions($attributes['options']);
        }
        $this->priceTax = $this->price + $this->tax;
//        $this->rowId = $this->generateRowId($this->id, $this->parentRowId);
    }

    /**
     * @param array|float $discounts
     */
    public function addDiscounts($discounts)
    {
        $currentDiscounts = $this->discounts;

        if(is_array($discounts)) {
            $currentDiscounts = array_merge($currentDiscounts, $discounts);
        } else {
            $currentDiscounts[] = $discounts;
        }

        $this->updateItem(['discounts' => $currentDiscounts]);
    }

    public function addDiscountAmounts($discountAmounts)
    {
        \Log::info('discountAmmounts', [$discountAmounts]);
        $currentDiscountAmounts = $this->discountAmounts;

        if(is_array($discountAmounts)) {
            $currentDiscountAmounts = array_merge($currentDiscountAmounts, $discountAmounts);
        } else {
            $currentDiscountAmounts[] = $discountAmounts;
        }

        \Log::info('currentDiscountAmounts', [$currentDiscountAmounts]);

        $this->updateItem(['discountAmounts' => $currentDiscountAmounts]);

        \Log::info('currentItem', [$this]);
    }

    public function removeDiscounts()
    {
        $this->updateItem(['discounts' => []]);
        $this->updateItem(['discountAmounts' => []]);
    }

    /**
     * @param array $options
     */
    public function addOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->options->put($key, $value);
        }
    }

    /**
     * @param null $decimals
     * @param null $decimalPoint
     * @param null $thousandSeparator
     * @return string
     */
    public function price($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        return $this->numberFormat($this->price, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * Get the formatted number.
     *
     * @param float $value
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeparator
     * @return string
     */
    private function numberFormat($value, $decimals, $decimalPoint, $thousandSeparator)
    {
        if (is_null($decimals)) {
            $decimals = is_null(config('cart.format.decimals')) ? 2 : config('cart.format.decimals');
        }
        if (is_null($decimalPoint)) {
            $decimalPoint = is_null(config('cart.format.decimal_point')) ? '.' : config('cart.format.decimal_point');
        }
        if (is_null($thousandSeparator)) {
            $thousandSeparator = is_null(config('cart.format.thousand_seperator')) ? ',' : config('cart.format.thousand_seperator');
        }
        return number_format($value, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * @param null $decimals
     * @param null $decimalPoint
     * @param null $thousandSeparator
     * @return string
     */
    public function priceTax($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        return $this->numberFormat($this->priceTax, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * @param null $decimals
     * @param null $decimalPoint
     * @param null $thousandSeparator
     * @return string
     */
    public function subtotal($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        return $this->numberFormat($this->subtotal, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * @param null $decimals
     * @param null $decimalPoint
     * @param null $thousandSeparator
     * @return string
     */
    public function total($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        return $this->numberFormat($this->total, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * @param null $decimals
     * @param null $decimalPoint
     * @param null $thousandSeparator
     * @return string
     */
    public function tax($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        return $this->numberFormat($this->tax, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * @param null $decimals
     * @param null $decimalPoint
     * @param null $thousandSeparator
     * @return string
     */
    public function taxTotal($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        return $this->numberFormat($this->taxTotal, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * @param $qty
     */
    public function setQuantity($qty)
    {
        if (empty($qty) || !is_numeric($qty))
            throw new \InvalidArgumentException('Please supply a valid quantity.');
        $this->qty = $qty;
    }

    /**
     * @param $taxRate
     * @return $this
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    /**
     * Get an attribute from the cart item or get the associated model.
     *
     * @param string $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) {
            return $this->{$attribute};
        }

        if ($attribute === 'priceTax') {
            return round($this->price + $this->tax, 2);
        }

        if ($attribute === 'subtotal') {
            return round($this->qty * $this->price * $this->period, 2);
        }

        if ($attribute === 'total') {
            $period = $this->periodMultiplier ?? $this->period;
            $total = $this->qty * ($this->priceTax) * $period;
            foreach($this->discounts as $discount) {
                $total *= (1 - (float)$discount / 100);
            }
            foreach($this->discountAmounts as $discount) {
                $total -= $discount;
            }
            return round($total, 2);
        }
        if ($attribute === 'tax') {
            return round($this->price * ($this->taxRate / 100), 2);
        }

        if ($attribute === 'taxTotal') {
            return round($this->tax * $this->qty, 2);
        }

        if($attribute === 'discountAmount') {
            return round($this->subtotal - $this->total, 2);
        }

        if($attribute === 'discountPercentage') {
            return round($this->discountAmount / $this->subtotal * 100, 2);
        }

        if($attribute === 'periodFullText') {
            if($this->period_text === 'm') {
                return trans_choice('main.months', $this->period);
            }

            if($this->period_text === 'y') {
                return trans_choice('main.years', $this->period);
            }
        }
        return null;
    }
}