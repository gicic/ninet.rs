<?php

use App\Models\Product;
use App\Models\ProductLine;
use App\Models\Subproduct;
use Illuminate\Database\Seeder;

class WhoisSeeder extends Seeder
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

            $line1 = ProductLine::where('code', 'cctld')->with('products')->first();
            $line2 = ProductLine::where('code', 'gtld')->with('products')->first();

            $whoiscctld = new Subproduct();
            $whoiscctld->code = 'whois-cctld';
            $whoiscctld->setTranslation('name', 'sr-Latn', 'Whois privatnost');
            $whoiscctld->setTranslation('name', 'en', 'Whois privacy');
            $whoiscctld->setTranslation('description', 'sr-Latn', 'Whois privatnost');
            $whoiscctld->setTranslation('description', 'en', 'Whois privacy');
            $whoiscctld->characteristics = '123';
            $whoiscctld->product_line_id = $line1->id;
            $whoiscctld->price_resident = 590.00;
            $whoiscctld->price_foreign = 5.00;
            $whoiscctld->quantity_from = 1;
            $whoiscctld->quantity_to = 1;
            $whoiscctld->public = 1;
            $whoiscctld->active = 1;
            $whoiscctld->save();

            $whoiscctld->products()->attach($line1->products->pluck('id')->toArray());

            $whoiscctld = new Subproduct();
            $whoiscctld->code = 'whois-gtld';
            $whoiscctld->setTranslation('name', 'sr-Latn', 'Whois privatnost');
            $whoiscctld->setTranslation('name', 'en', 'Whois privacy');
            $whoiscctld->setTranslation('description', 'sr-Latn', 'Whois privatnost');
            $whoiscctld->setTranslation('description', 'en', 'Whois privacy');
            $whoiscctld->characteristics = '123';
            $whoiscctld->product_line_id = $line2->id;
            $whoiscctld->price_resident = 1180.00;
            $whoiscctld->price_foreign = 10.00;
            $whoiscctld->quantity_from = 1;
            $whoiscctld->quantity_to = 1;
            $whoiscctld->public = 1;
            $whoiscctld->active = 1;
            $whoiscctld->save();

            $whoiscctld->products()->attach($line2->products->pluck('id')->toArray());

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}
