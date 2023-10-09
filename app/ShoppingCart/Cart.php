<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 3.7.2018.
 * Time: 16:03
 */

namespace App\ShoppingCart;


use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductLine;
use App\Models\Subproduct;
use App\Repositories\DiscountRepository;
use App\Repositories\ExchangeRateRepository;
use Illuminate\Events\Dispatcher;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

class Cart
{

    const DEFAULT_INSTANCE = 'default';
    /**
     * Instance of the session manager.
     *
     * @var \Illuminate\Session\SessionManager
     */
    private $session;
    /**
     * Instance of the event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $events;
    /**
     * Holds the current cart instance.
     *
     * @var string
     */
    private $instance;

    /**
     * Cart constructor.
     *
     * @param \Illuminate\Session\SessionManager $session
     * @param Dispatcher $events
     */
    public function __construct(SessionManager $session, Dispatcher $events)
    {
        $this->session = $session;
        $this->events = $events;
        $this->instance(self::DEFAULT_INSTANCE);
    }

    /**
     * @param null $instance
     * @return $this
     */
    public function instance($instance = null)
    {
        $instance = $instance ?: self::DEFAULT_INSTANCE;
        $this->instance = sprintf('%s.%s', 'cart', $instance);
        return $this;
    }

    /**
     * Get the current cart instance.
     *
     * @return string
     */
    public function currentInstance()
    {
        return str_replace('cart.', '', $this->instance);
    }

    /**
     * @param array $attributes
     * @return CartItem
     */
    public function add(array $attributes = [])
    {
        if( ! empty($attributes['parentRowId'])) {
            $parentRow = $this->get($attributes['parentRowId']);
            $attributes['period'] = $parentRow->period;
        }
        $cartItem = $this->createCartItem($attributes);
        $content = $this->getContent();

        if ($content->has($cartItem->rowId)) {
            if( ! empty($attributes['maxQty'])) {
                if(($content->get($cartItem->rowId)->qty + $cartItem->qty) <= $attributes['maxQty']) {
                    $cartItem->qty += $content->get($cartItem->rowId)->qty;
                } else {
                    $cartItem->qty = $content->get($cartItem->rowId)->qty;
                }
            }
        }

        $content->put($cartItem->rowId, $cartItem);

        $this->session->put($this->instance, $content);
        $this->events->fire('cart.added', $cartItem);

        return $cartItem;
    }

    public function removeHostingItemsForDomain($domain)
    {
        $content = $this->content()->where('category', 'hosting');
        foreach($content as $item) {
            if(!empty($item->options['domain'])) {
                if ($item->options['domain'] === $domain) {
                    $this->remove($item->rowId);
                }
            }
        }
    }

    /**
     * @param array $attributes
     * @return CartItem
     */
    private function createCartItem($attributes)
    {
        $cartItem = CartItem::createItem($attributes);
        $cartItem->setQuantity(array_get($attributes, 'qty', 1));
        $cartItem->setTaxRate(config('cart.tax'));

        return $cartItem;
    }

    /**
     * @return Collection
     */
    protected function getContent()
    {
        $content = $this->session->has($this->instance)
            ? $this->session->get($this->instance)
            : new Collection();
        return $content;
    }

    /**
     * @param $rowId
     * @param array $attributes
     * @return mixed
     */
    public function updateItem($rowId, array $attributes = [])
    {
        $cartItem = $this->get($rowId);
        $cartItem->updateItem($attributes);

        if(empty($cartItem->parentRowId)) {
            $additionalItems = $this->additionalItems($cartItem->rowId);
            foreach ($additionalItems as $additionalItem) {
                $additionalItem->period = $cartItem->period;
            }
        } else {
            $parentItem = $this->get($cartItem->parentRowId);
            $cartItem->period = $parentItem->period;
        }

        $content = $this->getContent();

        $content->put($cartItem->rowId, $cartItem);
        $this->session->put($this->instance, $content);
        $this->events->fire('cart.updated', $cartItem);

        return $cartItem;
    }

    public function get($rowId)
    {
        $content = $this->getContent();
        if (!$content->has($rowId))
            throw new InvalidRowIDException("The cart does not contain rowId {$rowId}.");
        return $content->get($rowId);
    }

    /**
     * @param $rowId
     * @return void
     */
    public function remove($rowId)
    {
        $cartItem = $this->get($rowId);
        $content = $this->getContent();
        $content->pull($cartItem->rowId);
        foreach ($content as $item) {
            if ($item->parentRowId == $cartItem->rowId) {
                $content->pull($item->rowId);
            }
        }
        if(Cart::count() == 0) {
            if(\Session::has('promo_codes')) {
                \Session::forget('promo_codes');
            }
        }
        $this->session->put($this->instance, $content);
        $this->events->fire('cart.removed', $cartItem);
    }

    /**
     * Destroy the current cart instance.
     *
     * @return void
     */
    public function destroy()
    {
        $this->session->remove($this->instance);
        \Session::forget('promo_codes');
        \Session::forget('promo_codes_backup');
    }

    /**
     * Get the content of the cart.
     *
     * @return \Illuminate\Support\Collection
     */
    public function content()
    {
        if (is_null($this->session->get($this->instance))) {
            return new Collection([]);
        }
        return $this->session->get($this->instance);
    }

    /**
     * @return Collection
     */
    public function mainItems()
    {
        $content = $this->content();

        $filtered = $content->where('parentRowId', null);

        return $filtered;
    }

    /**
     * @param null $parentRowId
     * @return Collection
     */
    public function additionalItems($parentRowId = null)
    {
        $content = $this->content();

        if ( ! isset($parentRowId)) {
            $filtered = $content->where('parentRowId', '!=', null);
        } else {
            $filtered = $content->where('parentRowId', $parentRowId);
        }

        return $filtered;
    }

    public function applyPromoCode($promoCode, $system = false)
    {
        if(\Session::has('promo_codes')) {
            $promoCodes = \Session::get('promo_codes');
        } else {
            $promoCodes = [];
        }

        if(!DiscountRepository::promoCodeExists($promoCode)) {
            return 'invalid';
        } else if (in_array($promoCode, $promoCodes)) {
            return 'used';
        } else {
            $localeCurrency = Currency::where('code', \App::getLocale() === 'sr-Latn' ? 'RSD' : 'EUR')->first();
            $promoCodes[] = $promoCode;
            \Session::put('promo_codes', $promoCodes);

            $mainItems = $this->mainItems();

            $promoCodeDB = DiscountRepository::getPromoCodeCollection($promoCode);
            $promoCodeProducts = $promoCodeDB->products->pluck('id')->toArray();


            $content = $this->getContent();
            foreach ($mainItems as $item) {
                $cartItem = $this->get($item->rowId);

                /**
                 * If promo code is not valid for period, skip this product
                 */
                $cartItemPeriodMonths = $cartItem->period;
                if($cartItem->period_text == 'y') {
                    $cartItemPeriodMonths *= 12;
                }

                if($promoCodeDB->discountOrderPeriods()->count() > 0) {
                    if(!in_array($cartItemPeriodMonths, $promoCodeDB->discountOrderPeriods()->pluck('order_period')->toArray())) {
                        continue;
                    }
                }

                if(in_array($cartItem->id, $promoCodeProducts)) {
                    if(!empty($promoCodeDB->percentage)) {
                        $cartItem->addDiscounts($promoCodeDB->percentage ?? 0);
                    }
                    if(!empty($promoCodeDB->discount_amount)) {
                        \Log::info('Amount', [ExchangeRateRepository::amountCurrency($promoCodeDB->discount_amount, $promoCodeDB->currency, $localeCurrency)]);
                        $cartItem->addDiscountAmounts(ExchangeRateRepository::amountCurrency($promoCodeDB->discount_amount, $promoCodeDB->currency, $localeCurrency));
                    }
                }

                $content->put($cartItem->rowId, $cartItem);
                \Log::info('CartItem', [$cartItem]);
            }

            $this->session->put($this->instance, $content);

            return 'success';
        }
    }

    public function clearDiscounts()
    {
        $content = $this->getContent();
        foreach ($content as $cartItem) {
            $cartItem->removeDiscounts();
            $content->put($cartItem->rowId, $cartItem);
        }
        $this->session->put($this->instance, $content);
    }

    /**
     * Get the number of items in the cart.
     *
     * @return int|float
     */
    public function count()
    {
        $content = $this->getContent();
        return $content->sum('qty');
    }

    public function hasCoRsDomain()
    {
        $coRsProduct = Product::where('code', 'cors')->first();
        if(empty($coRsProduct)) {
            return false;
        }
        $content = $this->getContent();
        $coRs = $content->where('id', $coRsProduct->id);
        return !empty($coRs) && count($coRs);
    }

    public function hasInRsDomain()
    {
        $inRsProduct = Product::where('code', 'inrs')->first();
        if(empty($inRsProduct)) {
            return false;
        }
        $content = $this->getContent();
        $inRs = $content->where('id', $inRsProduct->id);
        return !empty($inRs) && count($inRs);
    }

    public function requiredAdditionalNotAdded()
    {
        $content = $this->getContent();

        $productLine = ProductLine::where('code', 'ssd-vps-cpanel')->first();
        $products = Product::where('product_line_id', $productLine->id)->get();

        $vpsCpanel = false;
        foreach ($products as $product) {
            if (!empty($content->where('id', $product->id)) && count($content->where('id', $product->id))) {
                $vpsCpanel = true;
            }
        }

        if ($vpsCpanel) {
            $subproducts = Subproduct::where('product_line_id', $productLine->id)->pluck('id')->toArray();

            $additionalItems = $this->additionalItems();
            foreach ($additionalItems as $additionalItem) {
                if (in_array($additionalItem->id, $subproducts)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Magic method to make accessing the total, tax and subtotal properties possible.
     *
     * @param string $attribute
     * @return float|null
     */
    public function __get($attribute)
    {
        if ($attribute === 'total') {
            return $this->total();
        }
        if ($attribute === 'tax') {
            return $this->tax();
        }
        if ($attribute === 'subtotal') {
            return $this->subtotal();
        }
        return null;
    }

    /**
     * Checks if all terms and conditions for every item in cart is accepted
     *
     * @return bool
     */
    public function termsAccepted()
    {
        $content = $this->mainItems();

        foreach ($content as $item) {
            if($item->terms !== true) {
                return false;
            }
        }
        return true;
    }

    public function addDiscountsToItem($rowId, $discounts)
    {
        $cartItem = $this->get($rowId);
        $cartItem->addDiscounts($discounts);

        $content = $this->getContent();

        $content->put($cartItem->rowId, $cartItem);
        $this->session->put($this->instance, $content);
        $this->events->fire('cart.updated', $cartItem);

        return $cartItem;
    }

    /**
     * Get the total price of the items in the cart.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeparator
     * @return string
     */
    public function total($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        $content = $this->getContent();
        $total = $content->reduce(function ($total, CartItem $cartItem) {
            return $total + $cartItem->total;
        }, 0);
        return $this->numberFormat($total, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * Get the Formated number
     *
     * @param $value
     * @param $decimals
     * @param $decimalPoint
     * @param $thousandSeparator
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
     * Get the total tax of the items in the cart.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeparator
     * @return float
     */
    public function tax($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        $content = $this->getContent();
        $tax = $content->reduce(function ($tax, CartItem $cartItem) {
            return $tax + $cartItem->taxTotal;
        }, 0);
        return $this->numberFormat($tax, $decimals, $decimalPoint, $thousandSeparator);
    }

    /**
     * Get the subtotal (total - tax) of the items in the cart.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeparator
     * @return float
     */
    public function subtotal($decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        $content = $this->getContent();
        $subTotal = $content->reduce(function ($subTotal, CartItem $cartItem) {
            return $subTotal + $cartItem->subtotal;
        }, 0);
        return $this->numberFormat($subTotal, $decimals, $decimalPoint, $thousandSeparator);
    }

    public function backup()
    {
        $content = $this->getContent();
        \Session::put('cart_backup', $content);

        \Session::put('cart_contact_data_backup', \Session::get('cart_contact_data'));

        \Session::put('promo_codes_backup', \Session::get('promo_codes'));
    }

    public function restore()
    {
        $this->session->put($this->instance, \Session::has('cart_backup') ? \Session::get('cart_backup') : null);
        \Session::forget('cart_backup');

        \Session::put('cart_contact_data', \Session::has('cart_contact_data_backup') ? \Session::get('cart_contact_data_backup') : null);
        \Session::forget('cart_contact_data_backup');

        \Session::put('promo_codes', \Session::has('promo_codes') ? \Session::get('promo_codes') : null);
        \Session::forget('promo_codes_backup');
    }

}