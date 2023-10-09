<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 20.8.2018.
 * Time: 15:54
 */

namespace App\Repositories;


use App\Models\Payment;

class PaymentRepository
{

    /**
     * @param $transaction_id
     * @return bool
     */
    public static function twoCheckoutPaymentExists($transaction_id)
    {
        $payment = Payment::join('payment_channels', 'payments.payment_channel_id', 'payment_channels.id')
            ->where('payment_channel.code', '2co')
            ->where('payments.transaction_id', $transaction_id)
            ->first();

        return !empty($payment);
    }

    /**
     * @param $transaction_id
     * @return bool
     */
    public static function paypalPaymentExists($transaction_id)
    {
        $payment = Payment::join('payment_channels', 'payments.payment_channel_id', 'payment_channels.id')
            ->where('payment_channel.code', 'paypal')
            ->where('payments.transaction_id', $transaction_id)
            ->first();

        return !empty($payment);
    }

}