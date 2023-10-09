<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class);
    }

    public function latestRate()
    {
        return ExchangeRate::where('currency_id', $this->id)->orderBy('currency_date', 'desc')->first()['rate'];
    }

    public function __get($key)
    {
        if($key == 'latestRate') return $this->latestRate();

        return parent::__get($key);
    }

    /**
     * @param Currency $currencyTo
     * @param Carbon|null $date
     * @return mixed
     */
    public function getExchangeRate(Currency $currencyTo, Carbon $date = null)
    {
        $query = ExchangeRate::where('currency_from', $this->id)
            ->where('currency_to', $currencyTo->id);

        if(isset($date)) {
            $query->where('currency_date', $date->toDateString());
        }

        $query->orderBy('currency_date', 'desc');

        return $query->first();
    }
}
