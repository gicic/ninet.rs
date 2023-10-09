<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = ['payment_channel_id', 'order_id', 'amount', 'currency_id', 'transaction_id'];

    public function paymentChannel()
    {
        return $this->belongsTo(PaymentChannel::class);
    }

    /**
     * Payment's currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
