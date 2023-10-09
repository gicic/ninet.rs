<?php

use App\Models\Product;
use App\Models\WhmPackage;
use Illuminate\Database\Seeder;

class WhmPackagesSeeder extends Seeder
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

            $product1 = Product::where('code', 'hosting-basic')->first();
            $product2 = Product::where('code', 'hosting-gold')->first();

            $package1 = WhmPackage::create([
                'name' => 'test_basic',
                'product_id' => $product1->id
            ]);

            $package2 = WhmPackage::create([
                'name' => 'test_gold',
                'product_id' => $product2->id
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}
