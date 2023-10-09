<?php

use App\Models\Product;
use App\Models\ProductCharacteristic;
use Illuminate\Database\Seeder;

class ProductCharacteristicsSeeder extends Seeder
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

            foreach(Product::all() as $product) {
                $charac = new ProductCharacteristic();
                $charac->setTranslation('name', 'sr-Latn', 'Prostor na disku');
                $charac->setTranslation('name', 'en', 'Disk space');
                $charac->setTranslation('description', 'sr-Latn', '50 GB');
                $charac->setTranslation('description', 'en', '50 GB');
                $product->productCharacteristics()->save($charac);

                $charac = new ProductCharacteristic();
                $charac->setTranslation('name', 'sr-Latn', 'RAM');
                $charac->setTranslation('name', 'en', 'RAM');
                $charac->setTranslation('description', 'sr-Latn', '2 GB');
                $charac->setTranslation('description', 'en', '2 GB');
                $product->productCharacteristics()->save($charac);

                $charac = new ProductCharacteristic();
                $charac->setTranslation('name', 'sr-Latn', 'CPU');
                $charac->setTranslation('name', 'en', 'CPU');
                $charac->setTranslation('description', 'sr-Latn', '1');
                $charac->setTranslation('description', 'en', '1');
                $product->productCharacteristics()->save($charac);

                $charac = new ProductCharacteristic();
                $charac->setTranslation('name', 'sr-Latn', 'Protok');
                $charac->setTranslation('name', 'en', 'Bandwidth');
                $charac->setTranslation('description', 'sr-Latn', '1 TB');
                $charac->setTranslation('description', 'en', '1 TB');
                $product->productCharacteristics()->save($charac);

                $charac = new ProductCharacteristic();
                $charac->setTranslation('name', 'sr-Latn', 'IP adresa');
                $charac->setTranslation('name', 'en', 'IP address');
                $charac->setTranslation('description', 'sr-Latn', '1');
                $charac->setTranslation('description', 'en', '1');
                $product->productCharacteristics()->save($charac);

                $charac = new ProductCharacteristic();
                $charac->setTranslation('name', 'sr-Latn', 'Brzina porta');
                $charac->setTranslation('name', 'en', 'Port speed');
                $charac->setTranslation('description', 'sr-Latn', '1');
                $charac->setTranslation('description', 'en', '1');
                $product->productCharacteristics()->save($charac);
            }
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
