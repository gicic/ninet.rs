<?php

use App\Models\DomainExtension;
use App\Models\DomainVendor;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductLine;
use Illuminate\Database\Seeder;

class DomainVendorsAndExtensionsSeeder extends Seeder
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

            $rnids = DomainVendor::create([
                'name' => 'RNIDS',
                'code' => 'rnids',
                'service_model' => '\App\Services\Rnids\Facades\Rnids',
            ]);
            $wwd = DomainVendor::create([
                'name' => 'GoDaddy',
                'code' => 'godaddy',
                'service_model' => '\App\Services\GoDaddy\Facades\GoDaddyDomain',
            ]);
            $resello = DomainVendor::create([
                'name' => 'Resello',
                'code' => 'resello',
                'service_model' => '\App\Services\Resello\Facades\Resello',
            ]);

            $productCategory = new ProductCategory();
            $productCategory->code = 'domains';
            $productCategory->setTranslation('name', 'en', 'Domains');
            $productCategory->setTranslation('description', 'en', 'Domains');
            $productCategory->save();

            $productLineRs = new ProductLine();
            $productLineRs->code = 'cctld';
            $productLineRs->setTranslation('name', 'en', 'ccTLD');
            $productLineRs->setTranslation('name', 'sr-Latn', 'ccTLD');
            $productLineRs->setTranslation('description', 'en', 'ccTLD');
            $productLineRs->setTranslation('description', 'sr-Latn', 'ccTLD');
            $productCategory->productLines()->save($productLineRs);

            $productLineCom = new ProductLine();
            $productLineCom->code = 'gtld';
            $productLineCom->setTranslation('name', 'en', 'gTLD');
            $productLineCom->setTranslation('name', 'sr-Latn', 'gTLD');
            $productLineCom->setTranslation('description', 'en', 'gTLD');
            $productLineCom->setTranslation('description', 'sr-Latn', 'gTLD');
            $productCategory->productLines()->save($productLineCom);

            $rs = new Product();
            $rs->code = 'rs';
            $rs->setTranslation('name', 'en', '.rs');
            $rs->price_resident = 2350.00;
            $rs->price_foreign = 19.9;
            $productLineRs->products()->save($rs);

            $rsExt = new DomainExtension();
            $rsExt->name = '.rs';
            $rsExt->registration_price_resident = 2350;
            $rsExt->renewal_price_resident = 2350;
            $rsExt->transfer_price_resident = 2350;
            $rsExt->registration_price_foreign = 19.9;
            $rsExt->renewal_price_foreign = 19.9;
            $rsExt->transfer_price_foreign = 19.9;
            $rsExt->product()->associate($rs);
            $rsExt->registrationVendor()->associate($rnids);
            $rsExt->renewalVendor()->associate($rnids);
            $rsExt->transferVendor()->associate($rnids);
            $rsExt->save();

            $cors = new Product();
            $cors->code = 'cors';
            $cors->setTranslation('name', 'en', '.co.rs');
            $cors->price_resident = 920.00;
            $cors->price_foreign = 7.8;
            $productLineRs->products()->save($cors);

            $corsExt = new DomainExtension();
            $corsExt->name = '.co.rs';
            $corsExt->registration_price_resident = 920;
            $corsExt->renewal_price_resident = 920;
            $corsExt->transfer_price_resident = 920;
            $corsExt->registration_price_foreign = 7.8;
            $corsExt->renewal_price_foreign = 7.8;
            $corsExt->transfer_price_foreign = 7.8;
            $corsExt->product()->associate($cors);
            $corsExt->registrationVendor()->associate($rnids);
            $corsExt->renewalVendor()->associate($rnids);
            $corsExt->transferVendor()->associate($rnids);
            $corsExt->save();

            $com = new Product();
            $com->code = 'com';
            $com->setTranslation('name', 'en', '.com');
            $com->price_resident = 1250.00;
            $com->price_foreign = 10.5;
            $productLineCom->products()->save($com);

            $comExt = new DomainExtension();
            $comExt->name = '.com';
            $comExt->registration_price_resident = 1250;
            $comExt->renewal_price_resident = 1250;
            $comExt->transfer_price_resident = 1250;
            $comExt->registration_price_foreign = 10.5;
            $comExt->renewal_price_foreign = 10.5;
            $comExt->transfer_price_foreign = 10.5;
            $comExt->product()->associate($com);
            $comExt->registrationVendor()->associate($wwd);
            $comExt->renewalVendor()->associate($wwd);
            $comExt->transferVendor()->associate($wwd);
            $comExt->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}
