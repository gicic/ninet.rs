<?php

namespace App\Http\Controllers;

use App\ExternalResource;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentChannel;
use App\Repositories\PaymentRepository;
use App\ShoppingCart\CartToOrder;
use Illuminate\Http\Request;

class TwoCheckoutController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function charge(Request $request)
    {

        $order = CartToOrder::makeOrder();
        $cart = $this->twoCheckoutCart($order);

        if (config('services.2co.env_mode') === 'sandbox') {
            \Twocheckout::sandbox(true);
        } else {
            \Twocheckout::sandbox(false);
        }

        $url = \Twocheckout::$baseUrl . '/checkout/purchase?' . http_build_query($cart, '', '&amp;');
        return redirect($url);

    }

    /**
     * @param Order $order
     * @return array
     */
    public function twoCheckoutCart(Order $order)
    {

        $contact = $order->customer->contacts->where('contact_type_id', 1)->first();

        $data = [
            'sid'               => config('services.2co.sid'),
            'mode'              => '2CO',
            'merchant_order_id' => $order->order_number,
        ];

        if (!empty($contact)) {
            $data['card_holder_name'] = $contact->first_name . ' ' . $contact->last_name;
            $data['street_address'] = $contact->address;
            $data['city'] = $contact->city;
            $data['state'] = $contact->state;
            $data['zip'] = $contact->postal_code;
            $data['country'] = $contact->country->code;
            $data['email'] = $contact->email;
        }

        $counter = 0;
        foreach ($order->orderDetails as $detail) {
            $data['li_' . $counter . '_name'] = $detail->description;
            $data['li_' . $counter . '_price'] = $detail->price / $detail->quantity;
            $data['li_' . $counter . '_quantity'] = $detail->quantity;
            $counter++;
        }

        $data['currency_code'] = 'EUR';
        $data['x_receipt_link_url'] = route('twocheckout.charge.success');

        return $data;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function chargeSuccess(Request $request)
    {
        $params = $request->all();

        if(empty($params['sid'])) {
            abort(404);
        }

        $hashSecretWord = config('services.2co.secret_word');
        $hashSid = $params['sid'];
        $hashTotal = $params['total'];
        $hashOrder = $params['order_number'];
        $StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));

        return redirect()->route('purchase.success')->with(compact('order'));

//        $order = Order::findOrFail($params['merchant_order_id']);
//
//        if ($StringToHash !== $params['key']) {
//            return redirect()->route('purchase.finalize')->with(['error_message' => __('main.error_processing_twocheckout')]);
//        } else {
//            if ($order->totalPrice() == $params['total']) {
//                ExternalResource::createOrderResource($order);
//                return redirect()->route('purchase.success')->with(compact('order'));
//            }
//
//            return redirect()->route('purchase.success')->with(['error_message' => __('main.insufficient_funds')]);
//        }
    }

    /**
     * Used for receiving IPN messages
     *
     * @param Request $request
     */
    public function notification(Request $request)
    {
        $params = $request->all();
        $message = \Twocheckout_Notification::check($params, config('services.2co.secret_word'));

        if ($message['code'] !== 'Success') {
            \Log::channel('2co')->error('Invalid message code', ['data' => $params]);
        } else if ($params['message_type'] !== 'FRAUD_STATUS_CHANGED') {
            \Log::channel('2co')->error('Wrong message type', ['data' => $params]);
        } else if ($params['fraud_status'] !== 'pass') {
            \Log::channel('2co')->error('Invalid fraud status', ['data' => $params]);
        } else if (PaymentRepository::twoCheckoutPaymentExists($params['sale_id'])) {
            \Log::channel('2co')->error('Payment already exists', ['data' => $params]);
        } else {
            $this->savePayment($params);
        }
    }

    /**
     * @param $params
     * @return Payment|\Illuminate\Database\Eloquent\Model
     */
    public function savePayment($params)
    {
        $channel = PaymentChannel::where('code', '2co')->first();
        $order = Order::find($params['vendor_order_id']);
        $currency = Currency::where('code', $params['list_currency'])->first();

        return Payment::create([
            'payment_channel_id' => $channel->id,
            'order_id'           => $order->id ?? null,
            'amount'             => $params['invoice_list_amount'],
            'currency_id'        => !empty($currency) ? $currency->id : null,
            'transaction_id'     => $params['sale_id'],
        ]);
    }
}
