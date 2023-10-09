<?php

use App\Models\Product;
use App\Models\ProductLine;
use App\Models\Subproduct;
use Illuminate\Database\Seeder;

class VpsSubproductsSeeder extends Seeder
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

            $line1 = ProductLine::where('code', 'sas-vps')->first();

            $product1 = Product::where('code', 'vps-l')->first();
            $product2 = Product::where('code', 'vps-xl')->first();
            $product3 = Product::where('code', 'vps-xxl')->first();
            $product4 = Product::where('code', 'vps-ssd-l')->first();
            $product5 = Product::where('code', 'vps-ssd-xl')->first();
            $product6 = Product::where('code', 'vps-ssd-xxl')->first();

            $productIds = [$product1->id, $product2->id, $product3->id, $product4->id, $product5->id, $product6->id];

            $subproduct1 = new Subproduct();
            $subproduct1->code = 'cpanel-vps';
            $subproduct1->setTranslation('name', 'sr-Latn', 'cPanel licenca');
            $subproduct1->setTranslation('name', 'en', 'cPanel licence');
            $subproduct1->setTranslation('description', 'sr-Latn', 'cPanel licenca');
            $subproduct1->setTranslation('description', 'en', 'cPanel licence');
            $subproduct1->characteristics = '123';
            $subproduct1->product_line_id = $line1->id;
            $subproduct1->price_resident = 4000.00;
            $subproduct1->price_foreign = 35.00;
            $subproduct1->quantity_from = 1;
            $subproduct1->quantity_to = 1;
            $subproduct1->public = 1;
            $subproduct1->active = 1;
            $subproduct1->save();
            $subproduct1->products()->attach($productIds);

            $subproduct2 = new Subproduct();
            $subproduct2->code = 'ip-vps';
            $subproduct2->setTranslation('name', 'sr-Latn', 'IP Adresa');
            $subproduct2->setTranslation('name', 'en', 'IP Address');
            $subproduct2->setTranslation('description', 'sr-Latn', 'IP Adresa');
            $subproduct2->setTranslation('description', 'en', 'IP Address');
            $subproduct2->characteristics = '123';
            $subproduct2->product_line_id = $line1->id;
            $subproduct2->price_resident = 350.00;
            $subproduct2->price_foreign = 3.00;
            $subproduct2->quantity_from = 1;
            $subproduct2->quantity_to = 5;
            $subproduct2->public = 1;
            $subproduct2->active = 1;
            $subproduct2->save();
            $subproduct2->products()->attach($productIds);

            $subproduct3 = new Subproduct();
            $subproduct3->code = 'ram-vps';
            $subproduct3->setTranslation('name', 'sr-Latn', 'RAM');
            $subproduct3->setTranslation('name', 'en', 'RAM');
            $subproduct3->setTranslation('description', 'sr-Latn', 'RAM');
            $subproduct3->setTranslation('description', 'en', 'RAM');
            $subproduct3->characteristics = '123';
            $subproduct3->product_line_id = $line1->id;
            $subproduct3->price_resident = 1200.00;
            $subproduct3->price_foreign = 10.00;
            $subproduct3->quantity_from = 1;
            $subproduct3->quantity_to = 1;
            $subproduct3->public = 1;
            $subproduct3->active = 1;
            $subproduct3->save();
            $subproduct3->products()->attach($productIds);

            $subproduct4 = new Subproduct();
            $subproduct4->code = 'add-bwt-vps';
            $subproduct4->setTranslation('name', 'sr-Latn', 'Dodatni protok');
            $subproduct4->setTranslation('name', 'en', 'Additional bandwidth');
            $subproduct4->setTranslation('description', 'sr-Latn', 'Dodatni protok');
            $subproduct4->setTranslation('description', 'en', 'Additional bandwidth');
            $subproduct4->characteristics = '123';
            $subproduct4->product_line_id = $line1->id;
            $subproduct4->price_resident = 2200.00;
            $subproduct4->price_foreign = 20.00;
            $subproduct4->quantity_from = 1;
            $subproduct4->quantity_to = 1;
            $subproduct4->public = 1;
            $subproduct4->active = 1;
            $subproduct4->save();
            $subproduct4->products()->attach($productIds);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}
