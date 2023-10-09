<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 25.3.2019.
 * Time: 09:38
 */

namespace App\Repositories;


use App\Models\Currency;
use App\Models\ExchangeRate;

class ExchangeRateRepository
{

    /**
     * @param $amount
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @return float
     */
    public static function amountCurrency($amount, Currency $currencyFrom, Currency $currencyTo) : float
    {
        if($currencyFrom->code == $currencyTo->code) {
            return $amount;
        }

        $rate = $currencyFrom->getExchangeRate($currencyTo);

        return round(($amount * $rate->rate), 2);

    }

    public static function latestExchangeRate()
    {
        
    }

    /**
     * Get current exchange rate
     *
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     *
     * @return float
     */
    public static function exchangeRate(Currency $currencyFrom, Currency $currencyTo) : float
    {
        return ExchangeRate::where('currency_from', $currencyFrom->id)
            ->where('currency_to', $currencyTo->id)
            ->orderBy('currency_date', 'desc')
            ->first()['rate'];
    }
}