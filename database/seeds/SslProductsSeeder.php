<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductLine;
use App\Models\SslSecurityLevel;
use Illuminate\Database\Seeder;

class SslProductsSeeder extends Seeder
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
            $category->code = 'ssl';
            $category->setTranslation('name', 'sr-Latn', 'SSL sertifikati');
            $category->setTranslation('name', 'en', 'SSL certificates');
            $category->setTranslation('description', 'sr-Latn', 'Jedna od bitnijih stavki svakog online subjekta je zaštita podataka od prevara, zatim bankonih računa, neželjene pošte i tzv. phishinga. Da bi sve to rešili u jednom koraku potrebno je da uvedete SSL sertifikat (Secure Socket Layer).');
            $category->setTranslation('description', 'en', 'One of the most important things of every online object is data protection from frauds, as well as bank account, unwanted emails and so called phishings. To protect yourself from all of that you have to introduce the SSL (Secure Socket Layer).');
            $category->save();

            $rapid = new ProductLine();
            $rapid->code = 'rapid-ssl';
            $rapid->setTranslation('name', 'sr-Latn', 'Rapid');
            $rapid->setTranslation('name', 'en', 'Rapid');
            $rapid->setTranslation('description', 'sr-Latn', 'Rapid');
            $rapid->setTranslation('description', 'en', 'Rapid');
            $category->productLines()->save($rapid);

            $comodo = new ProductLine();
            $comodo->code = 'comodo-ssl';
            $comodo->setTranslation('name', 'sr-Latn', 'Comodo');
            $comodo->setTranslation('name', 'en', 'Comodo');
            $comodo->setTranslation('description', 'sr-Latn', 'Comodo');
            $comodo->setTranslation('description', 'en', 'Comodo');
            $category->productLines()->save($comodo);

            $geotrust = new ProductLine();
            $geotrust->code = 'geotrust-ssl';
            $geotrust->setTranslation('name', 'sr-Latn', 'Geotrust');
            $geotrust->setTranslation('name', 'en', 'Geotrust');
            $geotrust->setTranslation('description', 'sr-Latn', 'Geotrust');
            $geotrust->setTranslation('description', 'en', 'Geotrust');
            $category->productLines()->save($geotrust);

            $symantec = new ProductLine();
            $symantec->code = 'symantec-ssl';
            $symantec->setTranslation('name', 'sr-Latn', 'Symantec');
            $symantec->setTranslation('name', 'en', 'Symantec');
            $symantec->setTranslation('description', 'sr-Latn', 'Symantec');
            $symantec->setTranslation('description', 'en', 'Symantec');
            $category->productLines()->save($symantec);

            $thawte = new ProductLine();
            $thawte->code = 'thawte-ssl';
            $thawte->setTranslation('name', 'sr-Latn', 'Thawte');
            $thawte->setTranslation('name', 'en', 'Thawte');
            $thawte->setTranslation('description', 'sr-Latn', 'Thawte');
            $thawte->setTranslation('description', 'en', 'Thawte');
            $category->productLines()->save($thawte);

            $rapid1 = new Product();
            $rapid1->code = 'rapid-ssl';
            $rapid1->setTranslation('name', 'sr-Latn', 'RapidSSL Certificate');
            $rapid1->setTranslation('name', 'en', 'RapidSSL Certificate');
            $rapid1->setTranslation('description', 'sr-Latn', 'RapidSSL Certificate');
            $rapid1->setTranslation('description', 'en', 'RapidSSL Certificate');
            $rapid1->price_resident = 4000;
            $rapid1->price_foreign = 34;
            $rapid->products()->save($rapid1);

            $rapid1security = new SslSecurityLevel();
            $rapid1security->validation_type = 'DV';
            $rapid1security->domains_number = 'single';
            $rapid1security->wildcard = false;
            $rapid1->sslSecurityLevel()->save($rapid1security);

            $rapid2 = new Product();
            $rapid2->code = 'rapid-ssl-wildcard';
            $rapid2->setTranslation('name', 'sr-Latn', 'RapidSSL Wildcard Certificate');
            $rapid2->setTranslation('name', 'en', 'RapidSSL Wildcard Certificate');
            $rapid2->setTranslation('description', 'sr-Latn', 'RapidSSL Wildcard Certificate');
            $rapid2->setTranslation('description', 'en', 'RapidSSL Wildcard Certificate');
            $rapid2->price_resident = 16600;
            $rapid2->price_foreign = 141;
            $rapid->products()->save($rapid2);

            $rapid2security = new SslSecurityLevel();
            $rapid2security->validation_type = 'DV';
            $rapid2security->domains_number = 'single';
            $rapid2security->wildcard = true;
            $rapid2->sslSecurityLevel()->save($rapid2security);

            $comodo1 = new Product();
            $comodo1->code = 'comodo-essential-ssl';
            $comodo1->setTranslation('name', 'sr-Latn', 'Comodo Essential SSL Certificate');
            $comodo1->setTranslation('name', 'en', 'Comodo Essential SSL Certificate');
            $comodo1->setTranslation('description', 'sr-Latn', 'Comodo Essential SSL Certificate');
            $comodo1->setTranslation('description', 'en', 'Comodo Essential SSL Certificate');
            $comodo1->price_resident = 6600;
            $comodo1->price_foreign = 56;
            $comodo->products()->save($comodo1);

            $comodo1security = new SslSecurityLevel();
            $comodo1security->validation_type = 'DV';
            $comodo1security->domains_number = 'single';
            $comodo1security->wildcard = false;
            $comodo1->sslSecurityLevel()->save($comodo1security);

            $comodo2 = new Product();
            $comodo2->code = 'comodo-essential-ssl-wildcard';
            $comodo2->setTranslation('name', 'sr-Latn', 'Comodo Essential SSL Wildcard Certificate');
            $comodo2->setTranslation('name', 'en', 'Comodo Essential SSL Wildcard Certificate');
            $comodo2->setTranslation('description', 'sr-Latn', 'Comodo Essential SSL Wildcard Certificate');
            $comodo2->setTranslation('description', 'en', 'Comodo Essential SSL Wildcard Certificate');
            $comodo2->price_resident = 27800;
            $comodo2->price_foreign = 236;
            $comodo->products()->save($comodo2);

            $comodo2security = new SslSecurityLevel();
            $comodo2security->validation_type = 'DV';
            $comodo2security->domains_number = 'single';
            $comodo2security->wildcard = true;
            $comodo2->sslSecurityLevel()->save($comodo2security);

            $comodo3 = new Product();
            $comodo3->code = 'comodo-ev-ssl';
            $comodo3->setTranslation('name', 'sr-Latn', 'Comodo EV SSL Certificate');
            $comodo3->setTranslation('name', 'en', 'Comodo EV SSL Certificate');
            $comodo3->setTranslation('description', 'sr-Latn', 'Comodo EV SSL Certificate');
            $comodo3->setTranslation('description', 'en', 'Comodo EV SSL Certificate');
            $comodo3->price_resident = 37600;
            $comodo3->price_foreign = 319;
            $comodo->products()->save($comodo3);

            $comodo3security = new SslSecurityLevel();
            $comodo3security->validation_type = 'EV';
            $comodo3security->domains_number = 'single';
            $comodo3security->wildcard = false;
            $comodo3->sslSecurityLevel()->save($comodo3security);

            $comodo4 = new Product();
            $comodo4->code = 'comodo-instant-ssl';
            $comodo4->setTranslation('name', 'sr-Latn', 'Comodo Instant SSL');
            $comodo4->setTranslation('name', 'en', 'Comodo Instant SSL');
            $comodo4->setTranslation('description', 'sr-Latn', 'Comodo Instant SSL');
            $comodo4->setTranslation('description', 'en', 'Comodo Instant SSL');
            $comodo4->price_resident = 8400;
            $comodo4->price_foreign = 71;
            $comodo->products()->save($comodo4);

            $comodo4security = new SslSecurityLevel();
            $comodo4security->validation_type = 'OV';
            $comodo4security->domains_number = 'single';
            $comodo4security->wildcard = false;
            $comodo4->sslSecurityLevel()->save($comodo4security);

            $trust1 = new Product();
            $trust1->code = 'geotrust-businessid';
            $trust1->setTranslation('name', 'sr-Latn', 'GeoTrust True BusinessID');
            $trust1->setTranslation('name', 'en', 'GeoTrust True BusinessID');
            $trust1->setTranslation('description', 'sr-Latn', 'GeoTrust True BusinessID');
            $trust1->setTranslation('description', 'en', 'GeoTrust True BusinessID');
            $trust1->price_resident = 16700;
            $trust1->price_foreign = 142;
            $geotrust->products()->save($trust1);

            $trust1security = new SslSecurityLevel();
            $trust1security->validation_type = 'OV';
            $trust1security->domains_number = 'single';
            $trust1security->wildcard = false;
            $trust1->sslSecurityLevel()->save($trust1security);

            $trust2 = new Product();
            $trust2->code = 'geotrust-businessid-wildcard';
            $trust2->setTranslation('name', 'sr-Latn', 'GeoTrust True BusinessID WildCard');
            $trust2->setTranslation('name', 'en', 'GeoTrust True BusinessID WildCard');
            $trust2->setTranslation('description', 'sr-Latn', 'GeoTrust True BusinessID WildCard');
            $trust2->setTranslation('description', 'en', 'GeoTrust True BusinessID WildCard');
            $trust2->price_resident = 47000;
            $trust2->price_foreign = 399;
            $geotrust->products()->save($trust2);

            $trust2security = new SslSecurityLevel();
            $trust2security->validation_type = 'OV';
            $trust2security->domains_number = 'multiple';
            $trust2security->wildcard = true;
            $trust2->sslSecurityLevel()->save($trust2security);

            $symantec1 = new Product();
            $symantec1->code = 'symantec-secure-ssl';
            $symantec1->setTranslation('name', 'sr-Latn', 'Symantec Secure Site with EV');
            $symantec1->setTranslation('name', 'en', 'Symantec Secure Site with EV');
            $symantec1->setTranslation('description', 'sr-Latn', 'Symantec Secure Site with EV');
            $symantec1->setTranslation('description', 'en', 'Symantec Secure Site with EV');
            $symantec1->price_resident = 83500;
            $symantec1->price_foreign = 708;
            $symantec->products()->save($symantec1);

            $symantec1security = new SslSecurityLevel();
            $symantec1security->validation_type = 'EV';
            $symantec1security->domains_number = 'single';
            $symantec1security->wildcard = false;
            $symantec1->sslSecurityLevel()->save($symantec1security);

            $thawte1 = new Product();
            $thawte1->code = 'thawte-ev-ssl';
            $thawte1->setTranslation('name', 'sr-Latn', 'Thawte EV SSL');
            $thawte1->setTranslation('name', 'en', 'Thawte EV SSL');
            $thawte1->setTranslation('description', 'sr-Latn', 'Thawte EV SSL');
            $thawte1->setTranslation('description', 'en', 'Thawte EV SSL');
            $thawte1->price_resident = 25100;
            $thawte1->price_foreign = 213;
            $thawte->products()->save($thawte1);

            $thawte1security = new SslSecurityLevel();
            $thawte1security->validation_type = 'EV';
            $thawte1security->domains_number = 'single';
            $thawte1security->wildcard = false;
            $thawte1->sslSecurityLevel()->save($thawte1security);

            $thawte2 = new Product();
            $thawte2->code = 'thawte-123-ssl';
            $thawte2->setTranslation('name', 'sr-Latn', 'Thawte SSL123');
            $thawte2->setTranslation('name', 'en', 'Thawte SSL123');
            $thawte2->setTranslation('description', 'sr-Latn', 'Thawte SSL123');
            $thawte2->setTranslation('description', 'en', 'Thawte SSL123');
            $thawte2->price_resident = 13700;
            $thawte2->price_foreign = 116;
            $thawte->products()->save($thawte2);

            $thawte2security = new SslSecurityLevel();
            $thawte2security->validation_type = 'DV';
            $thawte2security->domains_number = 'single';
            $thawte2security->wildcard = false;
            $thawte2->sslSecurityLevel()->save($thawte2security);

            $thawte3 = new Product();
            $thawte3->code = 'thawte-web-server-ssl';
            $thawte3->setTranslation('name', 'sr-Latn', 'Thawte Web Server SSL');
            $thawte3->setTranslation('name', 'en', 'Thawte Web Server SSL');
            $thawte3->setTranslation('description', 'sr-Latn', 'Thawte Web Server SSL');
            $thawte3->setTranslation('description', 'en', 'Thawte Web Server SSL');
            $thawte3->price_resident = 16700;
            $thawte3->price_foreign = 142;
            $thawte->products()->save($thawte3);

            $thawte3security = new SslSecurityLevel();
            $thawte3security->validation_type = 'OV';
            $thawte3security->domains_number = 'single';
            $thawte3security->wildcard = false;
            $thawte3->sslSecurityLevel()->save($thawte3security);

            $thawte4 = new Product();
            $thawte4->code = 'thawte-wildcard-ssl';
            $thawte4->setTranslation('name', 'sr-Latn', 'Thawte Wildcard SSL');
            $thawte4->setTranslation('name', 'en', 'Thawte Wildcard SSL');
            $thawte4->setTranslation('description', 'sr-Latn', 'Thawte Wildcard SSL');
            $thawte4->setTranslation('description', 'en', 'Thawte Wildcard SSL');
            $thawte4->price_resident = 41900;
            $thawte4->price_foreign = 355;
            $thawte->products()->save($thawte4);

            $thawte4security = new SslSecurityLevel();
            $thawte4security->validation_type = 'DV';
            $thawte4security->domains_number = 'single';
            $thawte4security->wildcard = true;
            $thawte4->sslSecurityLevel()->save($thawte4security);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }

    }
}
