<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\OrderPeriod;
use App\Models\Product;
use App\Models\SslServerPlatform;
use App\Rules\ValidCountry;
use App\Rules\ValidDomain;
use App\Rules\ValidSslDomain;
use App\Shoppingcart\Facades\Cart;
use Hashids\Hashids;
use Illuminate\Http\Request;

class SslCartController extends Controller
{
    public function showCartSsl(Request $request, Hashids $hashids, $productId)
    {
        $productId = $hashids->decode($productId);

        $product = Product::where('id', $productId)->with('subproducts')->first();
        $countries = Country::orderBy('code')->get();
        $periods = $product->productLine->productCategory->orderPeriods;
        $serverPlatforms = SslServerPlatform::all();

        if ($product->productLine->productCategory->code !== 'ssl') {
            abort(404);
        }

        return view('carts.ssl', compact(['product', 'countries', 'periods', 'serverPlatforms']));
    }

    public function generateCsrCode(Request $request)
    {

        if (!$request->ajax()) {
            return abort(404);
        }

        $v = $this->csrValidator($request->all());

        if ($v->fails()) {
            return response()->json(['errors' => $v->getMessageBag()->toArray()]);
        }

        /* Podaci iz forme za generisanje CSR-a */
        $data = [
            'countryName'            => Country::find($request->country)->code,
            'stateOrProvinceName'    => $request->region,
            'localityName'           => $request->city,
            'organizationName'       => $request->company,
            'organizationalUnitName' => $request->department,
            'commonName'             => $request->domain,
            'emailAddress'           => $request->email,
        ];

        /* Konfiguracioni podaci */
        $configs = [
            'digest_alg'         => 'sha512',
            'x509_extensions'    => 'v3_ca',
            'req_extensions'     => 'v3_req',
            'private_key_bits'   => 4096,
            'private_key_type'   => OPENSSL_KEYTYPE_RSA,
            'encrypt_key'        => true,
            'encrypt_key_cipher' => OPENSSL_CIPHER_3DES
        ];

        /* Privatni kljuc za generisanje CSR-a */
        $private_key = openssl_pkey_new($configs);
        openssl_pkey_export($private_key, $pkeyout);

        /* Generisemo CSR (Certificate Signing Request) */
        $csr = openssl_csr_new($data, $private_key, $configs);
        openssl_csr_export($csr, $csrout);

        $data = [
            'csr'         => $csrout,
            'private_key' => $pkeyout
        ];

        return response()->json($data);
    }

    /**
     * @param  $data
     * @return  \Illuminate\Validation\Validator
     */
    public function csrValidator($data)
    {
        $rules = [
            'domain'     => ['required', new ValidSslDomain],
            'country'    => ['required', new ValidCountry],
            'region'     => 'required|string',
            'city'       => 'required|string',
            'company'    => 'required|string',
            'department' => 'required|string',
            'email'      => 'required|email',
        ];

        return \Validator::make($data, $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addToCart(Request $request)
    {
        $this->addToCartValidator($request->all())->validate();

        $product = Product::findOrFail($request->product_id);

        if ($request->has('ssl_period')) {
            $orderPeriod = OrderPeriod::where('product_category_id', $product->productLine->productCategory->id)
                ->where('id', $request->ssl_period)->first();

            if (!empty($orderPeriod)) {
                $period = $orderPeriod->period;
                $periodMultiplier = $orderPeriod->multiplier;
            } else {
                $period = $request->ssl_period;
            }
        }

        $cartItem = Cart::add([
            'id'               => $product->id,
            'name'             => $product->name,
            'qty'              => 1,
            'price'            => $product->getPrice(),
            'period'           => $period ?? 1,
            'period_text'      => 'y',
            'category'         => $product->productLine->productCategory->code,
            'periodMultiplier' => $periodMultiplier ?? null,
            'options'          => [
                'domain' => $request->ssl_domain,
                'csr_code' => $request->csr_code,
                'confirmation_email' => $request->ssl_confirmation_email,
                'server_platform_type' => $request->ssl_server_platform,
            ],
        ]);

        return redirect()->route('purchase.index');
    }

    public function addToCartValidator($data)
    {
        $sslAgreedRules = [];
        if($data['radio-csr-choice'] === 'auto') {
            $sslAgreedRules  = ['required'];
        }
        $rules = [
            'ssl_domain'             => ['required', new ValidSslDomain],
            'ssl_confirmation_email' => 'required|email',
            'ssl_server_platform'    => 'required',
            'csr_code'               => 'required',
            'ssl_period'             => 'required',
            'ssl_agreed'             => $sslAgreedRules,
        ];

        return \Validator::make($data, $rules);
    }

    public function getConfirmationEmailsOptions(Request $request)
    {
        if(!$request->ajax()) {
            abort(404);
        }

        $domain = $request->domain;
        $domainParts = explode('.', $domain);

        if(count($domainParts) === 2) {
            $domainForEmail = implode('.', $domainParts);
            $view = view('carts.partials.ssl-mail', compact('domainForEmail'))->render();
        }

        if(count($domainParts) === 3) {
            $domainForEmail = $domainParts[1] . '.' . $domainParts[2];
            $subdomainForEmail = implode('.', $domainParts);
            $view = view('carts.partials.ssl-mail', compact('domainForEmail', 'subdomainForEmail'))->render();
        }

        if (count($domainParts) === 4) {
            $domainForEmail = $domainParts[1] . '.' . $domainParts[2] . '.' . $domainParts[3];
            $subdomainForEmail = implode('.', $domainParts);
            $view = view('carts.partials.ssl-mail', compact('domainForEmail', 'subdomainForEmail'))->render();
        }

        if(!empty($view)) {
            return response()->json(['success' => true, 'view' => $view]);
        }
        return response()->json(['success' => false]);
    }
}
