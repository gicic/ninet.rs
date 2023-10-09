<?php

use App\Models\ExchangeRate;
use Illuminate\Database\Seeder;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * EURO
         */

        try {

            $euroRates = file(__DIR__ . '/ExchangeRate.txt');

            foreach ($euroRates as $line) {
                $lineParts = explode('|', $line);
                $erate = new ExchangeRate();
                $erate->currency_id = 2;
                $erate->rate = $lineParts[0];
                $erate->currency_date = date('Y-m-d', strtotime($lineParts[1]));
                $erate->save();
            }

            $usdRates = file(__DIR__ . '/ExchangeRateUSD.txt');

            foreach ($usdRates as $line) {
                $lineParts = explode('|', $line);
                $erate = new ExchangeRate();
                $erate->currency_id = 3;
                $erate->rate = $lineParts[0];
                $erate->currency_date = date('Y-m-d', strtotime($lineParts[1]));
                $erate->save();
            }

        } catch (Exception $e) {
            Log::error('ExchangeRateSeeder error', (array)$e->getMessage());
        }
    }
}
