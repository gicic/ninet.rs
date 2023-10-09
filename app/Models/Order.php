<?php

namespace App\Models;

use App\Repositories\ExchangeRateRepository;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['is_valid', 'status_id', 'origin_id', 'customer_id', 'currency_id'];
    /**
     * OrderDetails relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        $currency = Currency::find($this->currency_id);
        return $currency->code;
    }

    /**
     * @return float
     */
    public function totalPrice()
    {
        return $this->orderDetails()->sum('price');
    }

    public function taxBase()
    {
        $total = $this->totalPrice();
        $tax = config('general-data.tax');
        $taxBase = $total / (1 + $tax / 100);

        return round($taxBase, 2);
    }

    public function taxAmount()
    {
        return round(($this->totalPrice() - $this->taxBase()), 2);
    }

    public function payment()
    {
        return $this->belongsToMany(Payment::class)->withTimestamps();
    }

    /**
     * Order's payments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentsSum()
    {
        return $this->payment()->sum('amount') + $this->payments()->sum('amount');
    }

    public function setOrderNumber()
    {
        $orderNumberTime = date('Ymd-His');
        $increment = 1;
        $orderNumber = $orderNumberTime . '-' . $increment;
        while(Order::where('order_number', $orderNumber)->first() !== null) {
            $increment++;
            $orderNumber = $orderNumberTime . '-' . $increment;
        }

        $this->order_number = $orderNumber;
        return $this;
    }

    public function discountAmount()
    {
        $sum = 0;
        foreach($this->orderDetails as $detail) {
            $sum += $detail->discountAmount();
        }

        return round($sum, 2);
    }

    public function originalAmount()
    {
        $sum = 0;
        foreach ($this->orderDetails as $detail) {
            $sum += $detail->originalAmount();
        }
        return round($sum, 2);
    }

    public function get2COUrl()
    {
        $contact = $this->customer->contacts->where('contact_type_id', 1)->first();

        $data = [
            'sid'               => config('services.2co.sid'),
            'mode'              => '2CO',
            'merchant_order_id' => $this->order_number,
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
        foreach ($this->orderDetails as $detail) {
            $data['li_' . $counter . '_name'] = $detail->description;
            $data['li_' . $counter . '_price'] = $detail->price;
            $data['li_' . $counter . '_quantity'] = $detail->quantity;
            $counter++;
        }

        $data['currency_code'] = 'EUR';
        $data['x_receipt_link_url'] = route('twocheckout.charge.success');

        if (config('services.2co.env_mode') === 'sandbox') {
            \Twocheckout::sandbox(true);
        } else {
            \Twocheckout::sandbox(false);
        }

        $url = \Twocheckout::$baseUrl . '/checkout/purchase?' . http_build_query($data, '', '&amp;');
        return $url;
    }

    public function isPaid()
    {
        return (float)$this->totalAmount() <= (float)$this->paymentSumInTheCurrencyOfTheOrder();
    }

    public function totalAmount()
    {
        return $this->orderDetails()->sum('price');
    }

    public function paymentSumInTheCurrencyOfTheOrder()
    {
        if (isset($this->payments[0])){
            $payment_currency = $this->payments[0]->currency->code;
        }
        elseif(isset($this->payment[0])){
            $payment_currency = $this->payment[0]->currency->code;
        }

        $euro = Currency::where('code', 'EUR')->first();
        $rsd = Currency::where('code', 'RSD')->first();

        if (isset($payment_currency)) {
            if ($this->currency->code === 'EUR' && $payment_currency === 'RSD') {
                $exchangeRate = ExchangeRateRepository::exchangeRate($euro, $rsd);

                $payment_sum = $this->paymentsSum() / $exchangeRate;
            } else if ($this->currency->code === 'RSD' && $payment_currency === 'EUR') {
                $exchangeRate = ExchangeRateRepository::exchangeRate($rsd, $euro);

                $payment_sum = $this->paymentsSum() * $exchangeRate;
            } else {
                $payment_sum = $this->paymentsSum();
            }
        }
        else{
            $payment_sum = 0;
        }

        return $payment_sum;
    }
}
