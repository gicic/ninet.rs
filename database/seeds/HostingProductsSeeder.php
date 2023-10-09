<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductLine;
use Illuminate\Database\Seeder;

class HostingProductsSeeder extends Seeder
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

            $category = new ProductCategory();
            $category->code = 'hosting';
            $category->setTranslation('name', 'sr-Latn', 'Hosting');
            $category->setTranslation('name', 'en', 'Hosting');
            $category->setTranslation('description', 'sr-Latn', 'Hosting');
            $category->setTranslation('description', 'en', 'Hosting');
            $category->save();

            /**
             * Product Lines
             */
            $line1 = new ProductLine();
            $line1->code = 'web-hosting';
            $line1->product_category_id = $category->id;
            $line1->public_path = 'hosting';
            $line1->setTranslation('name', 'sr-Latn', 'WEB HOSTING');
            $line1->setTranslation('name', 'en', 'WEB HOSTING');
            $line1->setTranslation('description', 'sr-Latn', 'WEB HOSTING');
            $line1->setTranslation('description', 'en', 'WEB HOSTING');
            $line1->save();

            $line2 = new ProductLine();
            $line2->code = 'ssd-hosting';
            $line2->product_category_id = $category->id;
            $line2->public_path = 'ssdhosting';
            $line2->setTranslation('name', 'sr-Latn', 'SSD HOSTING');
            $line2->setTranslation('name', 'en', 'SSD HOSTING');
            $line2->setTranslation('description', 'sr-Latn', 'SSD HOSTING');
            $line2->setTranslation('description', 'en', 'SSD HOSTING');
            $line2->save();


            /**
             * Products
             */
            $product1 = new Product();
            $product1->code = 'hosting-basic';
            $product1->setTranslation('name', 'sr-Latn', 'Hosting BASIC');
            $product1->setTranslation('name', 'en', 'Hosting BASIC');
            $product1->setTranslation('description', 'sr-Latn', 'Hosting BASIC');
            $product1->setTranslation('description', 'en', 'Hosting BASIC');
            $product1->product_line_id = $line1->id;
            $product1->price_resident = 2000.00;
            $product1->price_foreign = 18.00;
            $product1->public = 1;
            $product1->active = 1;
            $product1->save();

            $product2 = new Product();
            $product2->code = 'hosting-standard';
            $product2->setTranslation('name', 'sr-Latn', 'Hosting STANDARD');
            $product2->setTranslation('name', 'en', 'Hosting STANDARD');
            $product2->setTranslation('description', 'sr-Latn', 'Hosting STANDARD');
            $product2->setTranslation('description', 'en', 'Hosting STANDARD');
            $product2->product_line_id = $line1->id;
            $product2->price_resident = 2900.00;
            $product2->price_foreign = 25.00;
            $product2->public = 1;
            $product2->active = 1;
            $product2->save();

            $product3 = new Product();
            $product3->code = 'hosting-gold';
            $product3->setTranslation('name', 'sr-Latn', 'Hosting GOLD');
            $product3->setTranslation('name', 'en', 'Hosting GOLD');
            $product3->setTranslation('description', 'sr-Latn', 'Hosting GOLD');
            $product3->setTranslation('description', 'en', 'Hosting GOLD');
            $product3->product_line_id = $line1->id;
            $product3->price_resident = 4000.00;
            $product3->price_foreign = 35.00;
            $product3->public = 1;
            $product3->active = 1;
            $product3->save();

            $product4 = new Product();
            $product4->code = 'hosting-platinum';
            $product4->setTranslation('name', 'sr-Latn', 'Hosting PLATINUM');
            $product4->setTranslation('name', 'en', 'Hosting PLATINUM');
            $product4->setTranslation('description', 'sr-Latn', 'Hosting PLATINUM');
            $product4->setTranslation('description', 'en', 'Hosting PLATINUM');
            $product4->product_line_id = $line1->id;
            $product4->price_resident = 2000.00;
            $product4->price_foreign = 18.00;
            $product4->public = 1;
            $product4->active = 1;
            $product4->save();

            $product5 = new Product();
            $product5->code = 'ssd-hosting-basic';
            $product5->setTranslation('name', 'sr-Latn', 'SSD Hosting BASIC');
            $product5->setTranslation('name', 'en', 'SSD Hosting BASIC');
            $product5->setTranslation('description', 'sr-Latn', 'SSD Hosting BASIC');
            $product5->setTranslation('description', 'en', 'SSD Hosting BASIC');
            $product5->product_line_id = $line2->id;
            $product5->price_resident = 2900.00;
            $product5->price_foreign = 25.00;
            $product5->public = 1;
            $product5->active = 1;
            $product5->save();

            $product6 = new Product();
            $product6->code = 'ssd-hosting-standard';
            $product6->setTranslation('name', 'sr-Latn', 'SSD Hosting STANDARD');
            $product6->setTranslation('name', 'en', 'SSD Hosting STANDARD');
            $product6->setTranslation('description', 'sr-Latn', 'SSD Hosting STANDARD');
            $product6->setTranslation('description', 'en', 'SSD Hosting STANDARD');
            $product6->product_line_id = $line2->id;
            $product6->price_resident = 4000.00;
            $product6->price_foreign = 35.00;
            $product6->public = 1;
            $product6->active = 1;
            $product6->save();

            $product7 = new Product();
            $product7->code = 'ssd-hosting-gold';
            $product7->setTranslation('name', 'sr-Latn', 'SSD Hosting GOLD');
            $product7->setTranslation('name', 'en', 'SSD Hosting GOLD');
            $product7->setTranslation('description', 'sr-Latn', 'SSD Hosting GOLD');
            $product7->setTranslation('description', 'en', 'SSD Hosting GOLD');
            $product7->product_line_id = $line2->id;
            $product7->price_resident = 4000.00;
            $product7->price_foreign = 35.00;
            $product7->public = 1;
            $product7->active = 1;
            $product7->save();

            $product8 = new Product();
            $product8->code = 'ssd-hosting-platinum';
            $product8->setTranslation('name', 'sr-Latn', 'SSD Hosting PLATINUM');
            $product8->setTranslation('name', 'en', 'SSD Hosting PLATINUM');
            $product8->setTranslation('description', 'sr-Latn', 'SSD Hosting PLATINUM');
            $product8->setTranslation('description', 'en', 'SSD Hosting PLATINUM');
            $product8->product_line_id = $line2->id;
            $product8->price_resident = 4000.00;
            $product8->price_foreign = 35.00;
            $product8->public = 1;
            $product8->active = 1;
            $product8->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}
