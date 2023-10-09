<?php

namespace App\Http\Controllers;

use App\ExternalResource;
use App\Mail\NestpayNotification;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\PaymentChannel;
use App\ShoppingCart\CartToOrder;
use App\ShoppingCart\Facades\Cart;
use Illuminate\Http\Request;

class NestpayController extends Controller
{

    public function generateForm(Request $request)
    {

        $order = CartToOrder::makeOrder();

        $data = $this->nestpayCart($order);

        $form = view('nestpay.payment-form', compact('data'))->render();

        return response()->json(compact('form'));

    }

    public function nestpayCart(Order $order)
    {
        $data = [];
        $data['items'] = [];
        foreach ($order->orderDetails as $detail) {
            $data['items'][] = [
                'desc'  => $detail->description,
                'price' => $detail->price,
                'qty'   => $detail->quantity,
                'total' => $detail->totalPrice(),
            ];
        }

        $contact = $order->customer->contacts->where('contact_type_id', 1)->first();

        $data['email'] = $contact->email;
        $data['tel'] = $contact->phone;
        $data['name'] = $contact->first_name . ' ' . $contact->last_name;
        $data['company_name'] = $contact->compnay_name ?? null;
        $data['address'] = $contact->address ?? null;
        $data['city'] = $contact->city;
        $data['state'] = $contact->state ?? null;
        $data['postal_code'] = $contact->postal_code;
        $data['country_code'] = $contact->country->code;

        $data['oid'] = $order->order_number;
        $data['rnd'] = $this->generateRnd(20);
        $data['amount'] = $order->totalPrice();
        $data['failUrl'] = \URL::temporarySignedRoute('nestpay.fail', now()->addMinutes(60));
        $data['okUrl'] = \URL::temporarySignedRoute('nestpay.success', now()->addMinutes(60));
        $data['shopUrl'] = \URL::temporarySignedRoute('nestpay.cancel', now()->addMinutes(60));

        $data['hash'] = $this->generateHash($data);

        return $data;
    }

    public function generateRnd($length = 20, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function generateHash($data)
    {
        $separator = '|';

        $string = $this->addSlashes(config('nestpay.clientid')) .
            $separator . $this->addSlashes($data['oid']) .
            $separator . $this->addSlashes($data['amount']) .
            $separator . $this->addSlashes($data['okUrl']) .
            $separator . $this->addSlashes($data['failUrl']) .
            $separator . $this->addSlashes(config('nestpay.trantype')) .
            $separator .
            $separator . $this->addSlashes($data['rnd']) .
            $separator .
            $separator .
            $separator .
            $separator . $this->addSlashes(config('nestpay.currency')) .
            $separator . $this->addSlashes(config('nestpay.storeKey'));

        return base64_encode(pack('H*', hash('sha512', $string)));

    }

    /**
     * @param $string
     * @return string
     */
    public function addSlashes($string)
    {
        return addcslashes($string, '|');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentSuccess(Request $request)
    {
        \Log::channel('nestpay')->info('Transaction received', ['data' => $request->all()]);

        if (! $request->hasValidSignature()) {
            abort(401);
        }

        if($request->merchantID !== config('nestpay.clientid')) {
            abort(404);
        }

        $data = $this->returnData($request);
        $order = Order::where('order_number', $request->oid)->with(['customer.contacts', 'orderDetails'])->first();

        if($order->orderStatus->code !== 'new') {
            abort(404);
        }

        $paymentChannel = PaymentChannel::where('code', 'intesa-card')->first();
        $existingPayment = Payment::where('payment_channel_id', $paymentChannel->id)->where('transaction_id', $request->TransId)->first();

        \Mail::to($data['email'])->send(new NestpayNotification($data, $order));

        if(empty($existingPayment)) {
            $currency = Currency::where('code', 'RSD')->first();

            try {
                $newPayment = new Payment([
                    'order_id'       => $order->id,
                    'amount'         => $request->amount,
                    'currency_id'    => $currency->id,
                    'transaction_id' => $request->TransId,
                ]);

                $paymentChannel->payments()->save($newPayment);
                $order->customer->activate();

                if((float)$newPayment->amount == (float)$order->totalPrice()) {
                    ExternalResource::createOrderResource($order);
                } else {
                    \Log::error('Insufficient funds', ['order' => $order]);
                }
            } catch (\Exception $e) {
                \Log::channel('nestpay')->error('Payment Insert Error', ['exception' => $e]);
            }
        }

        return redirect()->route('nestpay.success-transaction')->with(['payment' => $data, 'order' => $order]);
    }

    public function paymentSuccessPage(Request $request)
    {
        if(! \Session::has('payment') || ! \Session::has('order')) {
            abort(404);
        }
        return view('nestpay.success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentFail(Request $request)
    {

        if (! $request->hasValidSignature()) {
            abort(401);
        }

        if($request->merchantID !== config('nestpay.clientid')) {
            abort(404);
        }

        \Log::channel('nestpay')->error('Transaction Failed', ['request' => $request->all()]);

        $data = $this->returnData($request);

        $order = Order::where('order_number', $request->oid)->with(['customer.contacts', 'orderDetails'])->first();
        $failStatus = OrderStatus::where('code', 'failed')->first();
        \Mail::to($data['email'])->send(new NestpayNotification($data, $order, false));

        $order->status_id = $failStatus->id;
        $order->save();

        Cart::restore();

        return redirect()->route('nestpay.fail-transaction')->with(['payment' => $data, 'order' => $order]);
    }

    public function paymentFailPage(Request $request)
    {
        if(! \Session::has('payment') || ! \Session::has('order')) {
            abort(404);
        }
        return view('nestpay.fail');
    }

    public function cancelRedirect(Request $request)
    {
        Cart::restore();

        return redirect()->route('payment.page');
    }

    /**
     * @param Request $request
     * @return array
     */
    private function returnData(Request $request)
    {
        $data = [];
        $data['name'] = $request->BillToName;
        $data['address'] = $request->BillToStreet1 ?? $request->BillToStreet2;
        $data['city'] = $request->BillToCity;
        $data['postal_code'] = $request->BillToPostalCode;

        if($request->has('BillToCountry')) {
            $data['country'] = Country::where('code', $request->BillToCountry)->first();
        }

        $data['state'] = $request->state;
        $data['email'] = $request->email;
        $data['phone'] = $request->tel;
        $data['amount'] = $request->amount;

        $data['transaction_id'] = $request->TransId;
        $data['auth_code'] = $request->AuthCode;
        $data['order_id'] = $request->oid;
        $data['response'] = $request->Response;
        $data['proc_return_code'] = $request->ProcReturnCode;
        $data['md_status'] = $request->mdStatus;
        $data['transaction_date'] = $request->has('EXTRA_TRXDATE') ? date('d.m.Y H:i:s', strtotime($request->EXTRA_TRXDATE)) : null;

        $data['error_msg'] = $request->has('ErrMsg') ? $request->ErrMsg : ($request->has('mdErrorMsg') ? $request->mdErrorMsg : null);

        return $data;
    }

}
