<?php

namespace App\Http\Controllers;

use App\CommonOffer;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class SslOfferController extends Controller
{
    public function getOffer(Request $request)
    {
        $route = $request->route()->getName();

        $headTitle = \App::getLocale() === 'sr-Latn' ? 'SSL Sertifikati Srbija' : 'SSL Certificates';

        $category = ProductCategory::where('code', 'ssl')
            ->with('productLines.products.sslSecurityLevel')
            ->firstOrFail();

        $offer = new CommonOffer($category->name, $route);
        $offer->titleHtml = '<span class="c-yellow">' . $category->name . '</span>';
        $offer->description = $category->description;
        $offer->category = $category;
        $offer->cartRoute = 'cart.ssl';

        $offer->tabs = [
            'tab_1' => [
                'sr-Latn' => [
                    'title' => 'Podela SSL-a',
                    'content' => '
                        <h3 class="paragraph-title">Domenska validacija (DV):</h3>
                        <p>Da biste dobili SSL sertifikat potvrđen domenom, morate samo da dokažete da posedujete domen tako što ćete odgovoriti na e-poštu ili telefonski poziv koristeći podatke u Whois zapisu domena. Vaša kompanija ne mora biti potvrđena i u SSL sertifikat nije uneto nikakvo ime organizacije.
                        <br><br>
                        Rok izdavanja:  1 radni dan</p>
                        
                        <p><strong>Proces validacije:</strong>
                            Najčešće se proces vrši putem email-a ili je dovoljno da se promeni DNS. U njih spada Rapid SSL sertifikat.
                        </p>
                        
                        <h3 class="paragraph-title">Proširena validacija - EV (Extended validation)</h3>
                        <p>Proširena validacija SSL sertifikata ili EV SSL sertifikat donosi najvišu sigurnost za preduzeća i karakteriše je 2048-bitni potpis (signature) sa najvišom snagom sa 256-bitnim šifrovanjem. Prepoznaje ga 99,9% pretraživača i mobilnih uređaja. Najznačajnija karakteristika EV SSL sertifikata je tzv. “green bar” u browser-u koji posetiocima daje utisak potpune sigurnosti i povećava stopu konverzije online prodavnica.Rok izdavanja: 5-14 dana

                        <br>
                        Rok izdavanja: 5-14 dana
                        </p>
                        
                        <p><strong>Proces validacije:</strong>
                            <ul class="check-list">
                            <li>Forma na sajtu – ovaj korak je isti za bilo koji SSL</li>
                            <li>Verifiikacija kompanije ili pravnog subjekta – dokument koji se dostavlja kao dokaz o postojanju kompanije</li>
                            <li>Dokaz o postojanju</li>
                            <li>Fizička adresa kompanije – najčešće je to dokument koji se dobija od institucija koji dokazuje da zaista postojite</li>
                            <li>Poziv telefonom – Iz našeg iskustva, ovaj poziv dobijate direktno od kompanije čiji SSL kupujete (Comodo, Rapid SSL, Thawte..) Predlažemo da imate spreman dokument overen od strane advokata i sudskog tumača tzv. Legal Opinion Letter</li>
                            <li>Domenska verifikacija - pored formata ranije opisanih u vezi sa email adresama</li>
                        </ul>
                        </p>
                        
                        <h3 class="paragraph-title">Organizaciona validacija (OV):</h3>
                        <p>SSL sertifikat obezbeđuje šifrovanje i zahteva autentičnost preduzeća. Ovo je odličan način za šifriranje vaše veb stranice, a takođe svojim klijentima pružite potvrđene poslovne informacije. Vaši kupci će ceniti i transparentnost i vašu investiciju u njihovu sigurnost. Pre izdavanja, preduzeće koje zahteva OV SSL mora proći kroz određenu procenu poslovanja. Tokom ovog procesa provere od Vas će biti traženo:<br>
                        Rok izdavanja: 7-14 dana
                        </p>
                        
                        <ul class="check-list">
                            <li>Dokaz da je kompanija upisana u neki od poznatih direktorijuma, kao što je “Dun & Bradstreet” ili 11811.rs ukoliko se nalazite u Srbiji</li>
                            <li>Verifikacija putem telefona</li>
                            <li>Domenska verifikacija</li>
                        </ul>
                    '
                ],
                'en' => [
                    'title' => 'Podela SSL-a',
                    'content' => '
                        <h3 class="paragraph-title">Domain validation (DV):</h3>
                        <p>In order to receive SSL certificate,You have to prove the ownership of domain by replying to an email or by phone call using the domain Whois data..
                        <br><br>
                        Issue deadline:  1 work-day</p>
                        
                        <p><strong>Validation process:</strong>
                            Via an email or by changing DNS records.
                        </p>
                        
                        <h3 class="paragraph-title">Extended validation</h3>
                        <p>Extended validation or EV SSL certificate provides the highest security level for companies and it has 2048-bit signature with highest strengts and with 256-bit encoding. It is recognised by 99,9% of the browsers and mobile devices. The most important feature of the EV SSL certificate is so called green bar in browser address bar which gives the impression of total security and increases the conversion rate of an online store.
                        <br>
                        Issue deadline: 5-14 days
                        </p>
                        
                        <p><strong>Validation process:</strong>
                            <ul class="check-list">
                            <li>Website form</li>
                            <li>Company validation – a document that proves the existence of the company</li>
                            <li>Domain existence proof</li>
                            <li>Company location address</li>
                            <li>Phone call</li>
                            <li>Domain verification</li>
                        </ul>
                        </p>
                        
                        <h3 class="paragraph-title">Organisation validation (OV):</h3>
                    '
                ]
            ],

            'tab_2' => [
                'sr-Latn' => [
                    'title' => 'Preduslovi',
                    'content' => '

                        <p>1. Postojanje internet domena</p>
                        <p>2. Zbog sigurnosnih razloga potrebno je da Vaša email adresa sadrži i Vaš domen i neku od 5 reči u sledećem formatu:</p>
                        <ul class="check-list">
                            <li>admin@mojdomen.com</li>
                            <li>administrator@mojdomen.com</li>
                            <li>hostmaster@mojdomen.com</li>
                            <li>webmaster@mojdomen.com</li>
                            <li>postmaster@mojdomen.com</li>
                        </ul>',
                ],
                'en' => [
                    'title' => 'Preterms',
                    'content' => '

                        <p>For safety reasons it is necessary that your e-mail address contains your domain in the following format:</p>
                        <ul class="check-list">
                            <li>admin@mojdomen.com</li>
                            <li>administrator@mojdomen.com</li>
                            <li>hostmaster@mojdomen.com</li>
                            <li>webmaster@mojdomen.com</li>
                            <li>postmaster@mojdomen.com</li>
                        </ul>
                        <p>Any other e-mail address is invalid</p>',
                ]
            ],

            'tab_3' => [
                'sr-Latn' => [
                    'title' => 'Info',
                    'content' => '<h3 class="paragraph-title">Šta je SSL?</h3>
    
                            <p>SSL sertifikat (Secure Socket Layer) se instalira na serveru kao mali dodatak nakon čega se vrši enkripcija podataka koja je i svrha instalacije SSL-a.</p>
                            <p>SSL predstavlja fajl koji se koristi u procesu autentifikacije i zaštite sajtova i internet mreža. Svaki sertifikat se zakupljuje najmanje na jednu godinu, a najviše na period od dve godine. Odmah po uspostavljanju bezbedne veze između browser-a i servera nastavljate sa radom. </p>
                            
                            
                            <h3 class="paragraph-title">Zašto Webglobe SSL sertifikati?</h3>
                            <p>Primarni cilj sertifikata je zaštita podataka i sprečavanje malicioznih napada.</p>
                            
                            <h3 class="paragraph-title">Najpovoljnija ponuda SSL-a u Srbiji.</h3>
                            <p>Sajtovi sa SSL sertifikatima se bolje rangiraju na Google pretrazi . Avgusta 2014. godine Google je objavio na zvaničnom blogu za sigurnost podataka objavio "HTTPS as a ranking signal"</p>
                            
                            '
                ],
                'en' => [
                    'title' => 'Info',
                    'content' => '<h3 class="paragraph-title">Why Webglobe
 SSL certificates?</h3>
                            <p>The major goal of the certificate is data protection.</p>
                            <p>The most favourable offer of SSL\'s in Serbia.</p>
                            <p>Websites with SSL certificates are better ranked on Google search. In August 2014, Google published "HTTPS as a ranking signal" on their official blog for data security.</p>
                            
                            <h3 class="paragraph-title">What is SSL?</h3>
                            <p>SSL certificate (Secure Socket Layer) is installed on the server as a small add-on followed by data encryption which is in fact the purpose of installing the SSL.</p>
                            <p>SSL is a file used in the process of authentication and protection of websites and internet networks. Every certificate is rented for a minimum of one and maximum of 3-year period. You may continue with your work immediately after establishing a secure connection between a browser and a server.</p>
                         
                            '
                ]
            ],

            'tab_4' => [
                'sr-Latn' => [
                    'title' => 'Najčešća pitanja',
                    'content' => '<h3 class="paragraph-title">Ko može da koristi SSL zaštitu?</h3>
    
                            <ul class="check-list">
                                <li>Blogeri i mali web sajtovi</li>
                                <li>Online prodavnice na čijim sajtovima se ostavljaju lični podaci</li>
                                <li>Finansijske institucije i banke</li>
                                <li>Svi sajtovi na kojima se ostavljaju lični podaci</li>
                                <li>Vlasnici web aplikacija</li>
                            </ul>
                            
                            <h3 class="paragraph-title">Kako da znam koji sertifikat je najbolji za mene?</h3>
                            <p>Potrudili smo se da olakšamo posao budućim korisnicima SSL sertifikata i napravili "Čarobnjaka" preko koga ćete najbrže saznati koji SSL odgovara Vašim trenutnim potrebama. Možete nam se i obratiti putem tiketing sistema za savet pre kupovine</p>
                            
                            <h3 class="paragraph-title">Koje brendove zastupa Webglobe?</h3>
                            <p>U ponudu smo uvrtili samo najbolje i proverene kompanije koje se bave izdavanjem ssl sertifikata: <strong>Rapid SSL, Comodo, Geo Trust, Symantec i Thawte.</strong></p>
                            
                            <h3 class="paragraph-title">Da li mogu da koristim SSL u lokalnoj mreži?</h3>
                            <p>Ne. Za korišćenje SSL-a morate imati registrovan domen.</p>
                            '
                ],
                'en' => [
                    'title' => 'FAQ',
                    'content' => '<h3 class="paragraph-title">Are all the certificates identical?</h3>
    
                            <p>There are three types of certificates:</p>
    
                            <ul class="check-list">
                                <li>Extended Validation (EV) SSL Certificates</li>
                                <li>Organization Validation (OV) SSL Certificates</li>
                                <li>Domain Validation (DV) SSL Certificates</li>
                            </ul>
                            
                            <p>Certificates differ in the level of security and the conditions under which they are obtained. You can use our Wizard to determine which certificate would suit your needs.  </p>
                            
                            <h3 class="paragraph-title">How do I know whether a website where I leave data has the certificate or not?</h3>
                            
                            <p>In the upper left corner of the browser in the address bar you can see "https" instead of the standard http. Most often there is a padlock or a green field which upon clicking displays whether the SSL is installed or not.</p>
                            
                            <h3 class="paragraph-title">What brands does webglobe represent?</h3>
                            
                            <p>Our offer includes only the leading and well-established companies that deal with SSL certificates: Rapid SSL, Comodo, Geo Trust, Symantec and Thawte.</p>
                            
                            <h3 class="paragraph-title">Who can use SSL security?</h3>
    
                            <ul class="check-list">
                                <li>Bloggers and small websites</li>
                                <li>Online shops where personal data are left</li>
                                <li>Financial institutions and banks</li>
                                <li>All websites where personal data are left</li>
                                <li>Owners of web applications</li>
                            </ul>
                            
                            '
                ],
            ],
        ];

        return view('offers.ssl', compact(['offer', 'headTitle']));
    }

    public function getSslWizardProducts(Request $request)
    {
        $productsQuery = Product::selectRaw('products.*');

        $productsQuery->join('ssl_security_levels', 'products.id', '=', 'ssl_security_levels.product_id')
            ->join('product_lines', 'products.product_line_id', '=', 'product_lines.id')
            ->join('product_categories', 'product_lines.product_category_id', '=', 'product_categories.id')
            ->where('product_categories.code', 'ssl')
            ->where('products.public', 1)
            ->where('products.active', 1);

        if($request->has('domainTypeAnswer')) {
            $productsQuery->where('ssl_security_levels.validation_type', $request->domainTypeAnswer);
        }

        if($request->has('domainsNumberAnswer')) {
            $productsQuery->where('ssl_security_levels.domains_number', $request->domainsNumberAnswer);
        }

        if($request->has('wildcardAnswer')) {
            $wildcardValue = $request->wildcardAnswer === 'yes' ? 1 : 0;
            $productsQuery->where('ssl_security_levels.wildcard', $wildcardValue);
        }

        $products = $productsQuery->with('sslSecurityLevel')->get();

        $view = view('offers.partials.ssl-wizard-item', compact('products'))->render();

        return response()->json(compact('view'));

    }
}
