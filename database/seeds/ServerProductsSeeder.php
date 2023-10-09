<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCharacteristic;
use App\Models\ProductLine;
use Illuminate\Database\Seeder;

class ServerProductsSeeder extends Seeder
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

            $dedicatedCategory = new ProductCategory();
            $dedicatedCategory->code = 'dedicated-servers';
            $dedicatedCategory->setTranslation('name', 'sr-Latn', 'Namenski serveri');
            $dedicatedCategory->setTranslation('name', 'en', 'Dedicated servers');
            $dedicatedCategory->setTranslation('description', 'sr-Latn', 'Namenski serveri');
            $dedicatedCategory->setTranslation('description', 'en', 'Dedicated servers');
            $dedicatedCategory->save();

            $housingCategory = new ProductCategory();
            $housingCategory->code = 'server-housing';
            $housingCategory->setTranslation('name', 'sr-Latn', 'Server hausing');
            $housingCategory->setTranslation('name', 'en', 'Server housing');
            $housingCategory->setTranslation('description', 'sr-Latn', 'Server hausing');
            $housingCategory->setTranslation('description', 'en', 'Server housing');
            $housingCategory->save();

            $linuxLine = new ProductLine();
            $linuxLine->code = 'linux-servers';
            $linuxLine->setTranslation('name', 'sr-Latn', 'Linux serveri');
            $linuxLine->setTranslation('name', 'en', 'Linux servers');
            $linuxLine->setTranslation('description', 'sr-Latn', 'Linux serveri');
            $linuxLine->setTranslation('description', 'en', 'Linux servers');
            $dedicatedCategory->productLines()->save($linuxLine);

            $windowsLine = new ProductLine();
            $windowsLine->code = 'windows-servers';
            $windowsLine->setTranslation('name', 'sr-Latn', 'Windows serveri');
            $windowsLine->setTranslation('name', 'en', 'Windows servers');
            $windowsLine->setTranslation('description', 'sr-Latn', 'Windows serveri');
            $windowsLine->setTranslation('description', 'en', 'Windows servers');
            $dedicatedCategory->productLines()->save($windowsLine);

            $housingLine = new ProductLine();
            $housingLine->code = 'server-housing';
            $housingLine->setTranslation('name', 'sr-Latn', 'Server hausing');
            $housingLine->setTranslation('name', 'en', 'Server housing');
            $housingLine->setTranslation('description', 'sr-Latn', 'Server hausing');
            $housingLine->setTranslation('description', 'en', 'Server housing');
            $housingCategory->productLines()->save($housingLine);

            $products = [];

            $linux1 = new Product();
            $linux1->code = 'dedicated-webmaster';
            $linux1->setTranslation('name', 'sr-Latn', 'Dedicated Webmaster');
            $linux1->setTranslation('name', 'en', 'Dedicated Webmaster');
            $linux1->setTranslation('description', 'sr-Latn', 'Dedicated Webmaster');
            $linux1->setTranslation('description', 'en', 'Dedicated Webmaster');
            $linux1->price_resident = 8150;
            $linux1->price_foreign = 69;
            $linux1->public = 1;
            $linux1->active = 1;
            $linuxLine->products()->save($linux1);
            $products[] = $linux1;

            $linux2 = new Product();
            $linux2->code = 'dedicated-professional';
            $linux2->setTranslation('name', 'sr-Latn', 'Dedicated Professional');
            $linux2->setTranslation('name', 'en', 'Dedicated Professional');
            $linux2->setTranslation('description', 'sr-Latn', 'Dedicated Professional');
            $linux2->setTranslation('description', 'en', 'Dedicated Professional');
            $linux2->price_resident = 11600;
            $linux2->price_foreign = 99;
            $linux2->public = 1;
            $linux2->active = 1;
            $linuxLine->products()->save($linux2);
            $products[] = $linux2;

            $linux3 = new Product();
            $linux3->code = 'dedicated-advanced';
            $linux3->setTranslation('name', 'sr-Latn', 'Dedicated Advanced');
            $linux3->setTranslation('name', 'en', 'Dedicated Advanced');
            $linux3->setTranslation('description', 'sr-Latn', 'Dedicated Advanced');
            $linux3->setTranslation('description', 'en', 'Dedicated Advanced');
            $linux3->price_resident = 16400;
            $linux3->price_foreign = 139;
            $linux3->public = 1;
            $linux3->active = 1;
            $linuxLine->products()->save($linux3);
            $products[] = $linux3;

            $win1 = new Product();
            $win1->code = 'windows-webmaster';
            $win1->setTranslation('name', 'sr-Latn', 'Windows Webmaster');
            $win1->setTranslation('name', 'en', 'Windows Webmaster');
            $win1->setTranslation('description', 'sr-Latn', 'Windows Webmaster');
            $win1->setTranslation('description', 'en', 'Windows Webmaster');
            $win1->price_resident = 9900;
            $win1->price_foreign = 84;
            $win1->public = 1;
            $win1->active = 1;
            $windowsLine->products()->save($win1);
            $products[] = $win1;

            $win2 = new Product();
            $win2->code = 'windows-professional';
            $win2->setTranslation('name', 'sr-Latn', 'Windows Professional');
            $win2->setTranslation('name', 'en', 'Windows Professional');
            $win2->setTranslation('description', 'sr-Latn', 'Windows Professional');
            $win2->setTranslation('description', 'en', 'Windows Professional');
            $win2->price_resident = 14600;
            $win2->price_foreign = 124;
            $win2->public = 1;
            $win2->active = 1;
            $windowsLine->products()->save($win2);
            $products[] = $win2;

            $win3 = new Product();
            $win3->code = 'windows-advanced';
            $win3->setTranslation('name', 'sr-Latn', 'Windows Advanced');
            $win3->setTranslation('name', 'en', 'Windows Advanced');
            $win3->setTranslation('description', 'sr-Latn', 'Windows Advanced');
            $win3->setTranslation('description', 'en', 'Windows Advanced');
            $win3->price_resident = 19300;
            $win3->price_foreign = 164;
            $win3->public = 1;
            $win3->active = 1;
            $windowsLine->products()->save($win3);
            $products[] = $win3;

            $housing1 = new Product();
            $housing1->code = 'housing-l';
            $housing1->setTranslation('name', 'sr-Latn', 'Server Housing L');
            $housing1->setTranslation('name', 'en', 'Server Housing L');
            $housing1->setTranslation('description', 'sr-Latn', 'Server Housing L');
            $housing1->setTranslation('description', 'en', 'Server Housing L');
            $housing1->price_resident = 5600;
            $housing1->price_foreign = 48;
            $housing1->public = 1;
            $housing1->active = 1;
            $housingLine->products()->save($housing1);
            $products[] = $housing1;

            $housing2 = new Product();
            $housing2->code = 'housing-xl';
            $housing2->setTranslation('name', 'sr-Latn', 'Server Housing XL');
            $housing2->setTranslation('name', 'en', 'Server Housing XL');
            $housing2->setTranslation('description', 'sr-Latn', 'Server Housing XL');
            $housing2->setTranslation('description', 'en', 'Server Housing XL');
            $housing2->price_resident = 7000;
            $housing2->price_foreign = 60;
            $housing2->public = 1;
            $housing2->active = 1;
            $housingLine->products()->save($housing2);
            $products[] = $housing2;

            $housing3 = new Product();
            $housing3->code = 'housing-xxl';
            $housing3->setTranslation('name', 'sr-Latn', 'Server Housing XXL');
            $housing3->setTranslation('name', 'en', 'Server Housing XXL');
            $housing3->setTranslation('description', 'sr-Latn', 'Server Housing XXL');
            $housing3->setTranslation('description', 'en', 'Server Housing XXL');
            $housing3->price_resident = 10000;
            $housing3->price_foreign = 84;
            $housing3->public = 1;
            $housing3->active = 1;
            $housingLine->products()->save($housing3);
            $products[] = $housing3;

            foreach($products as $product) {
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
            die($e->getMessage());
        }
    }
}
