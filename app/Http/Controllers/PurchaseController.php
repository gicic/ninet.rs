<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Country;
use App\Models\Customer;
use App\Rules\checkHashedPassword;
use App\Shoppingcart\Facades\Cart;
use App\ShoppingCart\Facades\CartContact;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class PurchaseController extends Controller
{
    public function getPurchase()
    {
        $countries = Country::all();

        $customerType = null;
        if(Cart::hasCoRsDomain()) {
            $customerType = 'legal';
        }
        if(Cart::hasInRsDomain()) {
            $customerType = 'individual';
        }

        if(Cart::requiredAdditionalNotAdded()) {
            return redirect()->back()->withErrors(['license' => [__('main.license_required')]]);
        }

        return view('purchase', compact('countries', 'customerType'));
    }

    public function getIntPurchase()
    {
        $countries = Country::all();

        $customerType = null;
        if(Cart::hasCoRsDomain()) {
            $customerType = 'legal';
        }
        if(Cart::hasInRsDomain()) {
            $customerType = 'individual';
        }

        if(Cart::requiredAdditionalNotAdded()) {
            return redirect()->back()->withErrors(['license' => [__('main.license_required')]]);
        }

        return view('purchase-int', compact('countries', 'customerType'));
    }

    public function purchaseSuccess(Request $request)
    {
        return view('purchase-success');
    }

    public function getLoginData(Request $request)
    {
        $rules = [
            "email"  => "required|email|exists:customers",
            "password"  => "required",
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ], 400);
        }

        $customer = Customer::where('email', $request->email)->where('customer_status_id', 1)->first();
        $contact = Contact::where('customer_id', $customer->id)
            ->where('contact_type_id', 1)->first();
        $country = Country::find($contact->country_id);
        $country_name = $country->name;
        $contact->country = $country_name;

        if(\Hash::check($request->password, $customer->password)) {
            return \Response::json([
                'success' => true,
                'data' => $contact,
            ], 200);
        }

        return \Response::json([
            'success' => false,
            'errors' => ['password' => [trans('validation.custom.password.wrong')]],
        ], 400);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finalizePurchase(Request $request)
    {
        $v = $this->validator($request->all());
        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }
        if ($request->login_guest_select == 'log') {
            $customer = Customer::where('email', $request->user_login_email)->first();
            if ($customer->customerStatus->code != 'active') {
                return redirect()->back()->with('flash-danger', trans('main.archived'));
            }
            CartContact::set(['customerId' => $customer->id]);
        } else {
            $contactData = [
                'contact_type_id' => 1,
                'first_name'      => $request->first_name,
                'last_name'       => $request->last_name,
                'is_legal_entity' => $request->user_type_guest == 'legal_entity_guest',
                'address'         => $request->address,
                'postal_code'     => $request->postal_code,
                'city'            => $request->city,
                'country_id'      => $request->country,
                'state'           => $request->state,
                'phone'           => $request->phone,
                'email'           => $request->email,
            ];
            if ($request->user_type_guest == 'legal_entity_guest') {
                $contactData['company_name'] = $request->company_name;
                $contactData['company_registration_number'] = $request->company_registration_number;
                $contactData['company_tax_number'] = $request->company_tax_number;
            }

            CartContact::set($contactData);
        }

        return redirect()->route('payment.page');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPaymentPage(Request $request)
    {
        $session = $request->session();
        return view('payment');
    }

    public function getDialCode(Request $request)
    {
        if(!$request->ajax()) {
            return abort(400);
        }

        $country = Country::find($request->countryId);

        return response()->json(['dial_code' => $country->dial_code], 200);
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public function validator($data)
    {

        $rules = [
            'login_guest_select'   => 'required|in:guest,log',
        ];

        if (!empty($data['login_guest_select']) && $data['login_guest_select'] === 'log') {
            $rules = array_merge($rules, [
                'user_login_email'    => 'required|email|exists:customers,email',
                'user_login_password' => ['required', new checkHashedPassword('customers', $data['user_login_email'])],
            ]);
        }

        if (!empty($data['login_guest_select']) && $data['login_guest_select'] === 'guest') {
            $rules = array_merge($rules, [
                'user_type_guest' => 'required|in:individual_guest,legal_entity_guest',
                'first_name'      => 'required|alpha|max:30',
                'last_name'       => 'required|alpha|max:30',
                'email'           => 'required|email|unique:customers|unique:contacts',
                'phone'           => 'required|numeric',
                'country'         => 'required|integer|exists:countries,id',
                'city'            => 'required|string',
                'address'         => 'required|string',
                'postal_code'     => 'required|string',
            ]);

            if (!empty($data['user_type_guest']) && $data['user_type_guest'] === 'legal_entity_guest') {
                $rules = array_merge($rules, [
                    'company_name'                => 'required|string',
                    'company_registration_number' => 'required|string',
                    'company_tax_number'          => 'required|string',
                ]);
            }
        }

        $v = \Validator::make($data, $rules);

        return $v;
    }
}
