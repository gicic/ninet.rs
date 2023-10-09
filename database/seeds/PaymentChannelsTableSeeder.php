<?php

use App\Models\PaymentChannel;
use Illuminate\Database\Seeder;

class PaymentChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            PaymentChannel::create([
                'code' => 'paypal',
                'name' => 'PayPal',
            ]);

            PaymentChannel::create([
                'code' => '2co',
                'name' => '2Checkout',
            ]);

            PaymentChannel::create([
                'code' => 'intesa-card',
                'name' => 'Intesa - Online Card',
            ]);

            DB::commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            DB::rollBack();
        }
    }
}
