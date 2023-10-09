<?php

namespace App\Http\Controllers;

use App\Models\OrderPeriod;
use App\Models\Product;
use App\Models\Subproduct;
use App\Repositories\ProductRepository;
use App\Rules\ValidDomain;
use App\Services\Domains\Facades\Domains;
use App\Shoppingcart\Facades\Cart;
use Hashids\Hashids;
use Illuminate\Http\Request;

class HostingCartController extends Controller
{
    public function showCartHosting(Request $request, Hashids $hashids, $productId)
    {
        $productId = $hashids->decode($productId);

        $product = Product::where('id', $productId)->with('subproducts')->first();
        $periods = $product->productLine->orderPeriods;
        if(count($periods) == 0) {
            $periods = $product->productLine->productCategory->orderPeriods;
        }
        if ($product->productLine->productCategory->code !== 'hosting') {
            abort(404);
        }

        $domainExtensions = ProductRepository::getAllDomains();
        return view('carts.hosting', compact(['product', 'periods', 'domainExtensions']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addToCart(Request $request)
    {
        $data = $request->all();

        if ($data['radio-domain-availability'] === 'newDomain') {
            $domainTld = Product::find($data['domain_tld']);
            $data['domain'] = $data['domain_sld'] . $domainTld->name;
            $isAvailable = \App\Services\CoreAPI\Domains::isAvailable($data['domain_sld'], $domainTld->name);
            if(!$isAvailable->isAvailable) {
                return redirect()->back()->withErrors(['domain' => [__('main.domain_is_not_available')]]);
            }
        } else {
            $data['domain'] = $data['domain_sld'];
        }

        $this->addToCartValidator($data)->validate();

        $product = Product::findOrFail($request->product_id);

        if ($request->has('order_period')) {
            $orderPeriod = OrderPeriod::where('product_line_id', $product->productLine->id)
                ->where('id', $request->order_period)->first();
            if(empty($orderPeriod)) {
                $orderPeriod = OrderPeriod::where('product_category_id', $product->productLine->productCategory->id)
                    ->where('id', $request->order_period)->first();
            }
            if (!empty($orderPeriod)) {
                $period = $orderPeriod->period;
                $periodMultiplier = $orderPeriod->multiplier;
            } else {
                $period = $request->order_period;
            }
        }

        $options = ['domain' => $data['domain']];
        if($request->additional_services && count($request->additional_services)) {
            foreach($request->additional_services as $code => $quantity) {
                if($code === 'add-quota-100') {
                    $options['add_quota'] = $quantity;
                }
            }
        }

        $hostingItem = Cart::add([
            'id'               => $product->id,
            'name'             => $product->name,
            'qty'              => 1,
            'price'            => $product->getPrice(),
            'period'           => $period ?? 1,
            'period_text'      => $product->productLine->code === 'mail-servers' ? 'm' : 'y',
            'category'         => $product->productLine->productCategory->code,
            'periodMultiplier' => $periodMultiplier ?? null,
            'options'          => $options,
        ]);

        if ($data['radio-domain-availability'] === 'newDomain') {

            $domainProduct = Product::find($data['domain_tld']);

            Cart::add([
                'id'          => $domainProduct->id,
                'name'        => $data['domain'],
                'qty'         => 1,
                'price'       => $domainProduct->domainExtension->getPriceByPeriod($period),
                'period'      => $period ?? 1,
                'period_text' => 'y',
                'category'    => $domainProduct->productLine->productCategory->code,
            ]);
        }

        if($request->additional_services && count($request->additional_services)) {
            foreach($request->additional_services as $serviceCode => $quantity) {
                if($quantity > 0) {
                    $additionalService = Subproduct::where('code', $serviceCode)->first();
                    if (!empty($additionalService)) {
                        Cart::add([
                            'id'          => $additionalService->id,
                            'parentRowId' => $hostingItem->rowId,
                            'name'        => $additionalService->name,
                            'qty'         => $quantity,
                            'price'       => $additionalService->getPrice(),
                            'period'      => $period ?? 1,
                            'period_text' => 'm',
                            'category'    => $additionalService->productLine->productCategory->code,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('purchase.index');
    }

    public function addToCartValidator($data)
    {
        $rules = [
            'domain' => ['required', new ValidDomain],
        ];

        return \Validator::make($data, $rules);

    }
}
