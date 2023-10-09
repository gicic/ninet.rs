<?php

namespace App\Http\Controllers;

use App\ExternalResource;
use App\Mail\NestpayNotification;
use App\Models\Country;
use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\PaymentChannel;
use App\ShoppingCart\CartToOrder;
use App\ShoppingCart\Facades\Cart;
use Illuminate\Http\Request;

class RaiffeisenController extends Controller
{
    public function onlinePayment($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();

        $lang = $order->customer->getMainContact()->isDomestic();

        if ($order->orderStatus->code === 'cancelled'){
            return view('raiffeisen.order-cancelled', compact('lang'));
        }

        if ($order->isPaid()){
            return view('raiffeisen.order-has-been-paid', compact('order', 'lang'));
        }

        $data_pay = $this->raiffeisenCart($order);

        return view('raiffeisen.payment-form-online', compact('data_pay'))->render();
    }

    public function generateForm(Request $request)
    {
        $order = CartToOrder::makeOrder();

        $data_pay = $this->raiffeisenCart($order);

        $form = view('raiffeisen.payment-form', compact('data_pay'))->render();

        return response()->json(compact('form'));
    }

    public function raiffeisenCart(Order $order)
    {
        $euro = Currency::where('code', 'EUR')->first();
        $rsd = Currency::where('code', 'RSD')->first();
        $lang = $order->customer->getMainContact()->isDomestic();

        $exchangeRate = $this->exchangeRate($euro, $rsd);
        $payment_sum = $order->totalPrice() * $exchangeRate;

        $data_pay = [];

        $data_pay['Version'] = 1;
        $data_pay['MerchantID'] = config('raifffeisen.merchant_id');
        $data_pay['TerminalID'] = config('raifffeisen.terminal_id');
        $data_pay['Currency'] = config('raifffeisen.currency');
        $data_pay['locale'] = config('raifffeisen.lang');
        $data_pay['PurchaseTime'] = date("ymdHis");
        $data_pay['OrderID'] = $order->order_number;
        if ($lang == true){
            $data_pay['TotalAmount'] = $order->totalPrice();
        }else{
            $data_pay['TotalAmount'] = $payment_sum;
        }

        return $data_pay;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentSuccess(Request $request)
    {
        \Log::channel('raiffeisen')->info('Transaction received', ['data' => $request->all()]);

        \Log::info('Transaction received info', ['data' => $request->all()]);

        $order = Order::where('order_number', $request->OrderID)->with(['customer.contacts', 'orderDetails'])->first();
        $data = $this->returnData($request, $order);

        $paymentChannel = PaymentChannel::where('code', 'raiffeisen-card')->first();
        $existingPayment = Payment::where('payment_channel_id', $paymentChannel->id)->where('transaction_id', $request->ApprovalCode)->first();

        \Mail::to($data['email'])->send(new NestpayNotification($data, $order));

        if(empty($existingPayment)) {
            $currency = Currency::where('code', 'RSD')->first();

            try {
                $newPayment = new Payment([
                    'order_id'       => $order->id,
                    'amount'         => $request->TotalAmount / 100,
                    'currency_id'    => $currency->id,
                    'transaction_id' => $request->ApprovalCode,
                ]);

                $paymentChannel->payments()->save($newPayment);
                $order->customer->activate();

                $amount = $request->TotalAmount / 100;
                if((float)$amount == (float)$order->totalPrice()) {
                    if($order->orderStatus->code == 'new') {
                        ExternalResource::createOrderResource($order);
                    }
                    else{
                        ExternalResource::renewOrderResource($order);
                    }
                } else {
                    \Log::error('Insufficient funds', ['order' => $order]);
                }
            } catch (\Exception $e) {
                \Log::error('Payment Insert Error', ['exception' => $e]);

                \Log::channel('raiffeisen')->error('Payment Insert Error', ['exception' => $e]);
            }
        }

        return redirect()->route('raiffeisen.success-transaction')->with(['payment' => $data, 'order' => $order]);
    }

    public function paymentSuccessPage(Request $request)
    {
        return view('raiffeisen.success');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentFail(Request $request)
    {
        \Log::channel('raiffeisen')->error('Transaction Failed', ['request' => $request->all()]);

        $order = Order::where('order_number', $request->OrderID)->with(['customer.contacts', 'orderDetails'])->first();
        $data = $this->returnData($request, $order);

        $failStatus = OrderStatus::where('code', 'failed')->first();
        \Mail::to($data['email'])->send(new NestpayNotification($data, $order, false));

        $order->status_id = $failStatus->id;
        $order->save();

        Cart::restore();

        return redirect()->route('raiffeisen.fail-transaction')->with(['payment' => $data, 'order' => $order]);
    }

    public function paymentFailPage(Request $request)
    {
        return view('raiffeisen.fail');
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
    private function returnData(Request $request, $order)
    {
        $data = [];
//        $data['name'] = $order->customer->BillToName;
//        $data['address'] = $request->BillToStreet1 ?? $request->BillToStreet2;
//        $data['city'] = $request->BillToCity;
//        $data['postal_code'] = $request->BillToPostalCode;
//
//        if($request->has('BillToCountry')) {
//            $data['country'] = Country::where('code', $request->BillToCountry)->first();
//        }
//
//        $data['state'] = $request->state;
        if ($request->Email != null){
            $data['email'] = $request->Email;
        }else{
            $data['email'] = $order->customer->email;
        }
        $data['phone'] = $order->customer->getMainContact()->phone;
        $data['amount'] = $request->TotalAmount;

        $data['approval_code'] = $request->ApprovalCode;
        $data['tran_code'] = $request->TranCode;
        $data['order_id'] = $request->OrderID;
        $data['xid'] = $request->XID;
        $data['rrn'] = $request->Rrn;

        return $data;
    }

    public function notify(Request $request)
    {
        \Log::info('Transaction received info', ['notify' => $request->all()]);

//        $data = $request;
//
//        return view('raiffeisen.notify', compact('data'));
    }

    private function exchangeRate(Currency $currencyFrom, Currency $currencyTo) : float
    {
        return ExchangeRate::where('currency_from', $currencyFrom->id)
            ->where('currency_to', $currencyTo->id)
            ->orderBy('currency_date', 'desc')
            ->first()['rate'];
    }
}
