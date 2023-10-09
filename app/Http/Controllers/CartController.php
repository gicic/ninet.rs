<?php

namespace App\Http\Controllers;

use App\Models\OperatingSystem;
use App\Models\Order;
use App\Models\OrderPeriod;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SolusTemplate;
use App\Models\Subproduct;
use App\Repositories\ProductRepository;
use App\Rules\DomainSld;
use App\Services\Domains\Facades\Domains;
use App\Shoppingcart\Facades\Cart;
use App\ShoppingCart\InvalidRowIDException;
use App\Solus\Facade\Solus;
use Hashids\Hashids;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * Returns view of Header cart
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCartView()
    {
        return view('layouts.includes.cart');
    }

    /**
     * Returns view of side cart in cart details view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSideCartView()
    {
        return view('layouts.includes.side-cart');
    }

    public function getPaymentsCartView()
    {
        return view('partials.payments-cart');
    }

    /**
     * Returns cart details view
     *
     * @param Request $request
     * @param $cartRowId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCartVps(Request $request, $cartRowId)
    {
        try {
            $cartItem = Cart::get($cartRowId);
        } catch (InvalidRowIDException $e) {
            abort(404);
        }
        $product = Product::with('subproducts')->find($cartItem->id);
        $solusTemplates = SolusTemplate::orderBy('name', 'desc')->get();

        $category = ProductCategory::where('code', 'vps')->first();
        //$periods = $category->orderPeriods()->orderBy('period', 'asc')->get();

        $periods = $product->productLine->orderPeriods;
        if(count($periods) == 0) {
            $periods = $product->productLine->productCategory->orderPeriods;
        }

        return view('carts.vps', compact(['cartItem', 'product', 'solusTemplates', 'periods']));
    }

    public function showCartHosting(Request $request, $cartRowId)
    {
        try {
            $cartItem = Cart::get($cartRowId);
        } catch (InvalidRowIDException $e) {
            abort(404);
        }
        $product = Product::with('subproducts')->find($cartItem->id);
        $domainExtensions = ProductRepository::getAllDomains();

        $category = ProductCategory::where('code', 'hosting')->first();
        $periods = $category->orderPeriods()->orderBy('period', 'asc')->get();

        return view('carts.hosting', compact(['cartItem', 'product', 'domainExtensions', 'periods']));
    }

    public function showCartDomain(Request $request)
    {
        $cartDomains = Cart::content()->where('category', '=', 'domains')->where('parentRowId', null);

        if (empty($cartDomains) || !count($cartDomains)) {
            return redirect()->route('home');
        }

        $hosting = ProductCategory::where('code', 'hosting')
            ->with('productLines.products.productCharacteristics')
            ->first();

        $hostingPeriods = OrderPeriod::where('product_category_id', $hosting->id)->orderBy('period', 'asc')->get();

        return view('carts.domain', compact(['cartDomains', 'hosting', 'hostingPeriods']));
    }

    public function showCartLinux(Request $request, $cartRowId)
    {
        try {
            $cartItem = Cart::get($cartRowId);
        } catch (InvalidRowIDException $e) {
            abort(404);
        }
        $product = Product::with('subproducts')->find($cartItem->id);
        $operatingSystems = $product->productLine->operatingSystems;

        $category = ProductCategory::where('code', 'dedicated-servers')->first();
        $periods = $category->orderPeriods()->orderBy('period', 'asc')->get();

        return view('carts.servers', compact(['cartItem', 'product', 'operatingSystems', 'periods']));
    }

    public function showCartWindows(Request $request, $cartRowId)
    {
        try {
            $cartItem = Cart::get($cartRowId);
        } catch (InvalidRowIDException $e) {
            abort(404);
        }
        $product = Product::with('subproducts')->find($cartItem->id);
        $operatingSystems = $product->productLine->operatingSystems;

        $category = ProductCategory::where('code', 'dedicated-servers')->first();
        $periods = $category->orderPeriods()->orderBy('period', 'asc')->get();

        return view('carts.servers', compact(['cartItem', 'product', 'operatingSystems', 'periods']));
    }

    public function showCartHousing(Request $request, $cartRowId)
    {
        try {
            $cartItem = Cart::get($cartRowId);
        } catch (InvalidRowIDException $e) {
            abort(404);
        }
        $product = Product::with('subproducts')->find($cartItem->id);
        $operatingSystems = $product->productLine->operatingSystems;

        $category = ProductCategory::where('code', 'server-housing')->first();
        $periods = $category->orderPeriods()->orderBy('period', 'asc')->get();

        return view('carts.servers', compact(['cartItem', 'product', 'operatingSystems', 'periods']));
    }

    /**
     * Adds product to the cart
     *
     * @param Request $request
     * @param Hashids $hashids
     * @param $id
     * @param null $cartRoute
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addToCart(Request $request, Hashids $hashids, $id, $cartRoute = null)
    {
        $id = $hashids->decode($id)[0];
        $product = Product::find($id);

        $cartItem = Cart::add([
            'id'          => $id,
            'name'        => $product->name,
            'qty'         => 1,
            'price'       => $product->getPrice(),
            'period'      => 1,
            'period_text' => in_array($product->productLine->productCategory->code, ['vps', 'dedicated-servers', 'server-housing']) ? 'm' : 'y',
            'category'    => $product->productLine->productCategory->code,
        ]);

        if (!empty($cartRoute)) {
            return redirect()->route($cartRoute, ['cartRowId' => $cartItem->rowId]);
        } else {
            $content = Cart::content();
            return response()->json($content);
        }
    }

    public function addToCartPost(Request $request)
    {

        $productId = $request->productId;
        $product = Product::find($productId);

        if ($request->has('period')) {
            $orderPeriod = OrderPeriod::where('product_category_id', $product->productLine->productCategory->id)
                ->where('id', $request->period)->first();

            if (!empty($orderPeriod)) {
                $period = $orderPeriod->period;
                $periodMultiplier = $orderPeriod->multiplier;
            } else {
                $period = $request->period;
            }
        }


        if($request->has('options')) {
            if(!empty($request->options['domain'])) {
                Cart::removeHostingItemsForDomain($request->options['domain']);
            }
        }

        $cartItem = Cart::add([
            'id'               => $productId,
            'name'             => $product->name,
            'qty'              => 1,
            'price'            => $product->getPrice(),
            'period'           => $period ?? 1,
            'period_text'      => in_array($product->productLine->productCategory->code, ['vps', 'server-housing', 'dedicated-servers']) ? 'm' : 'y',
            'category'         => $product->productLine->productCategory->code,
            'periodMultiplier' => $periodMultiplier ?? null,
            'options'          => $request->has('options') ? $request->options : [],
        ]);
        return response()->json($cartItem);
    }

    /**
     * Add domains to cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addDomainsToCart(Request $request)
    {

        if ($request->ajax()) {
            $rules = [
                'domainName' => ['required', 'min:2', 'max:63', new DomainSld],
                'domainTld'  => 'numeric',
            ];
        } else {
            $rules = [
                'domain_sld'    => ['required', 'min:2', 'max:63', new DomainSld],
                'domain_tlds'   => 'required|array|min:1',
                'domain_tlds.*' => 'numeric',
            ];
        }

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }
            return redirect()->route('offer.domains')->withErrors($validator->errors())->withInput();
        }

        if ($request->ajax()) {
            $domainTlds = [$request->domainTldId];
            $domainSld = $request->domainName;
        } else {
            $domainTlds = $request->domain_tlds;
            $domainSld = $request->domain_sld;
        }
        foreach ($domainTlds as $tld) {
            $product = Product::find($tld);

            $domainItems = [];
            if (!Cart::content()->contains('name', $domainSld . $product->name)) {
                $domainItems[] = Cart::add([
                    'id'          => $tld,
                    'name'        => $domainSld . $product->name,
                    'qty'         => 1,
                    'price'       => $product->getDomainPrice('registration'),
                    'period'      => 1,
                    'period_text' => 'y',
                    'category'    => 'domains',
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json(['domainItem' => $domainItems[0], 'message' => __('main.domain_added')]);
        }
        return redirect()->route('cart.domain');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function domainIsAvailable(Request $request)
    {
        $sld = $request->domainName;
        $tld = Product::where('id', $request->domainTldId)->with('domainExtension.registrationVendor')->first();

        if (Domains::isAvailable($tld->domainExtension, $sld . $tld->name)) {
            return response()->json(['message' => __('main.domain_is_available'), 'value' => true]);
        }
        return response()->json(['message' => __('main.domain_is_not_available'), 'value' => false]);
    }

    /**
     * Adds subproduct to the cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAdditionalToCart(Request $request)
    {
        $id = $request->additionalID;
        $additional = Subproduct::find($id);

        $additionalItem = Cart::add([
            'id'          => $id,
            'name'        => $additional->name,
            'qty'         => $request->has('quantity') ? $request->quantity : 1,
            'price'       => $additional->getPrice(),
            'period'      => 1,
            'parentRowId' => $request->parentID,
            'maxQty'      => $additional->quantity_to,
            'category'    => $additional->productLine->productCategory->code,
        ]);

        if ($additional->code == 'ip-vps') {
            $attributes = [
                'options' => [
                    'ip_number' => $additionalItem->qty
                ],
            ];
            Cart::updateItem($request->parentID, $attributes);
        }

        if (in_array($additional->code, ['whois-cctld', 'whois-gtld'])) {
            $attributes = [
                'options' => [
                    'whois' => true,
                ],
            ];
            Cart::updateItem($request->parentID, $attributes);
        }

        return response()->json($additionalItem);
    }

    /**
     * Removes product or subproduct from the cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromCart(Request $request)
    {
        $rowId = $request->rowId;

        Cart::remove($rowId);

        $content = Cart::content();
        $total = Cart::total();

        return response()->json(compact(['content', 'total']));
    }

    public function removeWhoisFromCart(Request $request)
    {
        $rowId = $request->rowId;
        $row = Cart::get($rowId);

        Cart::updateItem($row->parentRowId, ['options' => ['whois' => false]]);
        Cart::remove($rowId);

        $content = Cart::content();
        $total = Cart::total();

        return response()->json(compact(['content', 'total']));
    }

    /**
     * Updates Cart Item
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCartItem(Request $request)
    {
        $rowId = $request->rowId;
        $attributes = $request->updateData;

        $cartItem = Cart::get($rowId);
        $product = Product::find($cartItem->id);
        if (isset($attributes['period']) && empty($cartItem->parentRowId)) {
            if (in_array($cartItem->category, ['hosting', 'dedicated-servers', 'server-housing', 'ssl', 'vps'])) {
                $OrderPeriod = OrderPeriod::find($attributes['period']);
                if (empty($OrderPeriod)) {
                    $attributes['period'] = 1;
                } else {
                    $attributes['period'] = $OrderPeriod->period;
                    $attributes['periodMultiplier'] = $OrderPeriod->multiplier;
                }
            }

            if($cartItem->category === 'domains') {
                $attributes['price'] = $product->domainExtension->getPriceByPeriod($attributes['period']);
            }
        }

        Cart::updateItem($rowId, $attributes);

        $content = Cart::content();
        $total = Cart::total();

        return response()->json(compact('content', 'total'));
    }

    public function applyPromoCode(Request $request)
    {
        if(!$request->ajax()) {
            abort(404);
        }

        $promoCode = $request->promoCode;

        $result = Cart::applyPromoCode($promoCode);

        if($result == 'invalid') {
            return response()->json(['success' => false, 'message' => __('main.invalid_promo_code')]);
        }

        if($result == 'used') {
            return response()->json(['success' => false, 'message' => __('main.promo_code_already_entered')]);
        }

        if($result == 'success') {
            return response()->json(['success' => true, 'message' => __('main.promo_code_success')]);
        }

        return response()->json(['success' => false], 400);
    }
}
