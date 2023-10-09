<?php

use App\Models\Product;
use App\Models\SolusPlan;
use Illuminate\Database\Seeder;

class SolusPlansTableSeeder extends Seeder
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

            SolusPlan::create([
                'product_id' => Product::where('code', 'vps-l')->first()->id,
                'name' => 'VPS L',
            ]);

            SolusPlan::create([
                'product_id' => Product::where('code', 'vps-xl')->first()->id,
                'name' => 'VPS XL',
            ]);

            SolusPlan::create([
                'product_id' => Product::where('code', 'vps-xxl')->first()->id,
                'name' => 'VPS XXL',
            ]);

            DB::commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            DB::rollBack();
        }
    }
}
