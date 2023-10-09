<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductLine;
use App\Models\Subproduct;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
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
            $category->code = 'vps';
            $category->setTranslation('name', 'sr-Latn', 'Virtuelni Privatni Serveri');
            $category->setTranslation('name', 'en', 'Virtual Private Servers');
            $category->setTranslation('description', 'sr-Latn', 'VPS');
            $category->setTranslation('description', 'en', 'VPS');
            $category->save();

            /**
             * Product Lines
             */
            $line1 = new ProductLine();
            $line1->code = 'sas-vps';
            $line1->product_category_id = $category->id;
            $line1->public_path = 'vps-servers';
            $line1->setTranslation('name', 'sr-Latn', 'VPS');
            $line1->setTranslation('name', 'en', 'VPS');
            $line1->setTranslation('description', 'sr-Latn', 'VPS');
            $line1->setTranslation('description', 'en', 'VPS');
            $line1->save();

            $line2 = new ProductLine();
            $line2->code = 'ssd-vps';
            $line2->product_category_id = $category->id;
            $line2->public_path = 'ssd-vps';
            $line2->setTranslation('name', 'sr-Latn', 'SSD VPS');
            $line2->setTranslation('name', 'en', 'SSD VPS');
            $line2->setTranslation('description', 'sr-Latn', 'VPS');
            $line2->setTranslation('description', 'en', 'VPS');
            $line2->save();


            /**
             * Products
             */
            $product1 = new Product();
            $product1->code = 'vps-l';
            $product1->setTranslation('name', 'sr-Latn', 'VPS L');
            $product1->setTranslation('name', 'en', 'VPS L');
            $product1->setTranslation('description', 'sr-Latn', 'VPS L');
            $product1->setTranslation('description', 'en', 'VPS L');
            $product1->product_line_id = $line1->id;
            $product1->price_resident = 2000.00;
            $product1->price_foreign = 18.00;
            $product1->public = 1;
            $product1->active = 1;
            $product1->save();

            $product2 = new Product();
            $product2->code = 'vps-xl';
            $product2->setTranslation('name', 'sr-Latn', 'VPS XL');
            $product2->setTranslation('name', 'en', 'VPS XL');
            $product2->setTranslation('description', 'sr-Latn', 'VPS L');
            $product2->setTranslation('description', 'en', 'VPS L');
            $product2->product_line_id = $line1->id;
            $product2->price_resident = 2900.00;
            $product2->price_foreign = 25.00;
            $product2->public = 1;
            $product2->active = 1;
            $product2->save();

            $product3 = new Product();
            $product3->code = 'vps-xxl';
            $product3->setTranslation('name', 'sr-Latn', 'VPS XXL');
            $product3->setTranslation('name', 'en', 'VPS XXL');
            $product3->setTranslation('description', 'sr-Latn', 'VPS L');
            $product3->setTranslation('description', 'en', 'VPS L');
            $product3->product_line_id = $line1->id;
            $product3->price_resident = 4000.00;
            $product3->price_foreign = 35.00;
            $product3->public = 1;
            $product3->active = 1;
            $product3->save();

            $product4 = new Product();
            $product4->code = 'vps-ssd-l';
            $product4->setTranslation('name', 'sr-Latn', 'SSD VPS L');
            $product4->setTranslation('name', 'en', 'SSD VPS L');
            $product4->setTranslation('description', 'sr-Latn', 'VPS L');
            $product4->setTranslation('description', 'en', 'VPS L');
            $product4->product_line_id = $line2->id;
            $product4->price_resident = 2000.00;
            $product4->price_foreign = 18.00;
            $product4->public = 1;
            $product4->active = 1;
            $product4->save();

            $product5 = new Product();
            $product5->code = 'vps-ssd-xl';
            $product5->setTranslation('name', 'sr-Latn', 'SSD VPS XL');
            $product5->setTranslation('name', 'en', 'SSD VPS XL');
            $product5->setTranslation('description', 'sr-Latn', 'VPS L');
            $product5->setTranslation('description', 'en', 'VPS L');
            $product5->product_line_id = $line2->id;
            $product5->price_resident = 2900.00;
            $product5->price_foreign = 25.00;
            $product5->public = 1;
            $product5->active = 1;
            $product5->save();

            $product6 = new Product();
            $product6->code = 'vps-ssd-xxl';
            $product6->setTranslation('name', 'sr-Latn', 'SSD VPS XXL');
            $product6->setTranslation('name', 'en', 'SSD VPS XXL');
            $product6->setTranslation('description', 'sr-Latn', 'VPS L');
            $product6->setTranslation('description', 'en', 'VPS L');
            $product6->product_line_id = $line2->id;
            $product6->price_resident = 4000.00;
            $product6->price_foreign = 35.00;
            $product6->public = 1;
            $product6->active = 1;
            $product6->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }

    }
}
