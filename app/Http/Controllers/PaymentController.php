<?php

namespace App\Http\Controllers;

use App\Mail\PreInvoice;
use App\ShoppingCart\CartToOrder;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentRedirect(Request $request)
    {
        if(isset($request->phone_notification) && $request->phone_notification === 'on'){
            $phone_notification = true;
        }
        else{
            $phone_notification = false;
        }

        $v = $this->validator($request->all());

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        if($request->payment === 'paypal_payment') {
            return redirect()->route('paypal.express');
        }

        if($request->payment === '2co_payment') {
            return redirect()->route('twocheckout.charge');
        }

        if($request->payment === 'pre-invoice') {
            $order = CartToOrder::makeOrder($phone_notification);

            return redirect()->route('purchase.success');
        }

        return redirect()->back()->with(['error_message' => __('main.payment_type_invalid')]);
        
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public function validator($data)
    {
        $rules = [
            'g-recaptcha-response' => 'required|captcha',
            'terms_and_conditions' => 'required',
            'payment' => 'required|in:paypal_payment,card_payment,2co_payment,pre-invoice',
        ];
        $v = \Validator::make($data, $rules);
        return $v;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsValidation(Request $request)
    {
        $v = $this->validator($request->all());

        if($v->fails()) {
            return response()->json(['success' => false, 'errors' => $v->errors()]);
        }

        return response()->json(['success' => true]);
    }
}
