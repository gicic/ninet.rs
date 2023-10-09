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
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{

    /**
     * @var ExpressCheckout
     */
    protected $provider;

    /**
     * PayPalController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $options = [
            'BRANDNAME'   => 'NiNet Company',
            'LOGOIMG'     => url('/assets/images/logo.png'),
            'CHANNELTYPE' => 'Merchant'
        ];
        $this->provider = new ExpressCheckout();
        $this->provider->addOptions($options);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function expressCheckout(Request $request)
    {
        $order = CartToOrder::makeOrder();

        $cart = $this->paypalCart($order);
        $response = $this->provider->setExpressCheckout($cart);

        return redirect($response['paypal_link']);
    }

    /**
     * @param Order $order
     * @return array
     */
    public function paypalCart(Order $order)
    {
        $data = [];
        $data['items'] = [];
        foreach ($order->orderDetails as $detail) {
            $data['items'][] = [
                'name'  => $detail->description,
                'price' => $detail->price,
                'qty'   => $detail->quantity,
            ];
        }
        $data['invoice_id'] = $order->order_number;
        $data['invoice_description'] = "Order #{$order->order_number}";
        $data['return_url'] = route('paypal.express.success');
        $data['cancel_url'] = route('purchase.finalize');
        $data['total'] = $order->totalPrice();
        return $data;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function expressCheckoutSuccess(Request $request)
    {
        $token = $request->get('token');

        if(empty($token)) {
            abort(404);
        }

        $PayerID = $request->get('PayerID');
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            return redirect()->route('purchase.finalize')->with(['error_message' => __('main.error_processing_paypal')]);
        }

        return redirect()->route('purchase.success')->with(compact('order'));

//        $order = Order::where('order_number', $response['INVNUM'])->firstOrFail();
//
//        $cart = $this->paypalCart($order);
//        $payment_info = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
//        $status = $payment_info['PAYMENTINFO_0_PAYMENTSTATUS'];
//        if ($status === 'Completed') {
//            if ($order->totalPrice() == $response['AMT']) {
//                ExternalResource::createOrderResource($order);
//                return redirect()->route('purchase.success')->with(compact('order'));
//            }
//
//            return redirect()->route('purchase.success')->with(['error_message' => __('main.insufficient_funds')]);
//        }
//
//        return redirect()->route('payment.page')->with(['error_message' => __('main.error_processing_paypal')]);
    }

    /**
     * @param Request $request
     */
    public function notification(Request $request)
    {
        $request->merge(['cmd' => '_notify-validate']);
        $post = $request->all();

        $response = (string)$this->provider->verifyIPN($post);

        if ($response !== 'VERIFIED') {
            \Log::channel('paypal')->error('Verification failed', ['data' => $post]);
        } else if ($post['payment_status'] !== 'Completed') {
            \Log::channel('paypal')->error('Invalid payment status', ['data' => $post]);
        } else if (PaymentRepository::paypalPaymentExists($post['txn_id'])) {
            \Log::channel('paypal')->error('Payment already exists', ['data' => $post]);
        } else {
            $this->savePayment($post);
        }
    }

    /**
     * @param $post
     * @return Payment|\Illuminate\Database\Eloquent\Model
     */
    public function savePayment($post)
    {
        $channel = PaymentChannel::where('code', 'paypal')->first();
        $order = Order::where('order_number', $post['invoice'])->first();
        $currency = Currency::where('code', $post['mc_currency'])->first();

        return Payment::create([
            'payment_channel_id' => $channel->id,
            'order_id'           => $order->id ?? null,
            'amount'             => $post['mc_gross'],
            'currency_id'        => !empty($currency) ? $currency->id : null,
            'transaction_id'     => $post['txn_id'],
        ]);
    }
}
