<?php

namespace App\Http\Controllers;

use App\CommonOffer;
use App\Repositories\ProductLineRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class HostingOfferController extends Controller
{
    public function getWebHostingOffer(Request $request)
    {
        $route = $request->route()->getName();
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Najbolji Domaći Web Hosting - već od 25 eur' : 'European Web Hosting';

        $product_line = ProductLineRepository::getByCode('web-hosting');
        $products = ProductRepository::getByProductLine($product_line->id);
        $products = $products->take(4);

        $billingType = $product_line->billing_type;
        if(empty($billingType)) {
            $billingType = $product_line->productCategory->billing_type;
        }

        $offer = new CommonOffer($product_line->name, $route);
        $offer->titleHtml = '<span class="c-yellow">' . $product_line->name . '</span>';
        $offer->description = \App::getLocale() === 'sr-Latn' ? 'Fer cene. Fantastične performanse.' : 'We are one of few hosting companies in Serbia which uses its own resources in rendering services. And that is why Webglobe can offer their customers packages at considerably more favorable conditions than any other in this region.';
        $offer->items = $products;
        $offer->colspan = $this->colSpan(count($offer->items));
        $offer->cartRoute = 'cart.hosting';
        $offer->billingType = trans('main.' . $billingType);

        $offer->tabs = [
            'tab_1' => [
                'sr-Latn' => [
                    'title' => 'Zašto Webglobe hosting?',
                    'content' => '<h3 class="paragraph-title"><span class="fa fa-bar-chart"></span>Odlične performanse</h3>
                            
                            <p>Naši hosting klijenti imaju na raspolaganju dovoljno prostora i protoka i za najzahtevnije sajtove. Uz bilo koji hosting paket dobijate mogućnost da postavite još najmanje 4 sajta.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-battery"></span>Na sigurnom ste</h3>
                            <p>Svi serveri se nalaze u Webglob-ovom data centru u Nišu. Za razliku većine provajdera sami vodimo računa o resursima.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-certificate"></span>Samostalni WEB dizajn</h3>
                            <p><img style="height: 50px" src="' . url('images/spublisher.png') . '" alt=""> <br><br>
                            Možete samostalno da kreirate svoju jednostavnu prezentaciju i bez prethodnog iskustva.
                            </p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-battery"></span>Besplatni SSL certifikat</h3>
                            <p><img style="height: 50px" src="' . url('images/autossl1.png') . '" alt=""> <br><br>
                            Potpuno besplatno kod nas imate Comodo SSL certifikat u sklopu svakog hosting paketa. Potrebno je samo da ga aktivirate.
                            </p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-refresh"></span>Vraćamo novac ako niste zadovoljni</h3>
                            <p>
                            Smatramo da je 30 dana dovoljno da se uverite u kvalitet naših usluga. Klijenti koji iz nekog razloga ne žele da i dalje koriste naš hosting dobice svoj novac nazad, bez pitanja.
                            </p>'
                ],
                'en' => [
                    'title' => 'Why Webglobe hosting?',
                    'content' => '<h3 class="paragraph-title"><span class="fa fa-certificate"></span>SSL</h3>
                            
                            <p>Each user receives a free Comodo SSL for all of their domains.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-user"></span>Support</h3>
                            <p>We are recognizable by customer support that does not leave any problems unresolved. For the most common questions, we made a knowledge base available to everyone.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-refresh"></span>Regular backup</h3>
                            <p><img style="height: 50px" src="' . url('images/spublisher.png') . '" alt=""> <br><br>
                            We know how important it is for users to have the last copy of their site. The backup is done on a daily, weekly and monthly basis.
                            </p>'
                ]
            ],

            'tab_2' => [
                'sr-Latn' => [
                    'title' => 'Podrška',
                    'content' => '<p>Znamo koliko je bitno da korisnici imaju poslednju kopiju svog sajta. Ažuriranje podataka se radi na dnevnom, nedeljnom i mesečnom nivou. Posedujemo najsavremenija rešenja u pogledu sigurnosti servera koji se nalaze u Webglobovom data centru u Nišu. Koristimo SSL enskripciju a narocitu pažnju poklanjamo bezbednosti korisnika.</p>

                        <p>U sve to spadaju:</p>
                        <ul class="check-list">
                            <li>Direktorijumi zaštićeni lozinkom</li>
                            <li>Error log</li>
                            <li>Hotlink zaštita</li>
                            <li>Leech zaštita</li>
                            <li>GnuPG keys</li>
                            <li>Redundantni  link od strane 3 provajdera</li>
                        </ul>
                        
                        <h3 class="paragraph-title"><span class="fa fa-user"></span>Korisnička podrška</h3>
                        
                        <p>Znamo da ne možete sve sami i zato smo mi tu. Pored standardne pomoći klijentima. Podršku pružamo preko tiketing sistema i telefona svakog dana od 08-22 h.</p>
                        <p>Webglobe tehnička podrška je na rapolaganju za:</p>
                        
                        <ul>
                            <li>Besplatnu migraciju sajta sa drugog hosting naloga</li>
                            <li>Besplatnu instalaciju CMSa po želji</li>
                            <li>Konsultacije oko izbora dodataka i podešavanje</li>
                            <li>Bazu znanja sa uputstvima</li>
                        </ul>
                        
                        <h3 class="paragraph-title"><span class="fa fa-refresh"></span>Redovan backup</h3>
                        <p>Znamo koliko je bitno da korisnici imaju poslednju kopiju svog sajta. Ažuriranje podataka se radi na dnevnom, nedeljnom i mesečnom nivou.</p>
                        ',
                ],
                'en' => [
                    'title' => 'cPanel',
                    'content' => '<p>As part of the standard offer, Webglobe hosting has provided its customers with CPanel hosting management as a standard in the hosting industry.</p>
                                <p>We use SSL encryption and pay special attention to user security.</p>
                                
                                <ul class="check-list">
                                <li>Password-protected directories</li>
                                <li>Error log</li>
                                <li>Hotlink protection</li>
                                <li>Leech protection</li>
                                <li>GnuPG keys</li>
                                <li>Radiant link by 3 providers</li>
                                </ul>
'
                ]
            ],

            'tab_3' => [
                'sr-Latn' => [
                    'title' => 'cPanel',
                    'content' => '<h3 class="paragraph-title"><span class="fa fa-cloud"></span>Softver</h3>
    
                            <ul class="check-list">
                                <li>PHP</li>
                                <li>Perl</li>
                                <li>GD Library</li>
                                <li>Imagemanager</li>
                                <li>Optimize website</li>
                                <li>Virusscaner</li>
                                <li>Cronjob</li>
                            </ul>
                            
                            <h3 class="paragraph-title"><span class="fa fa-columns"></span>cPanel</h3>
    
                            <ul class="check-list">
                                <li>Lako upravljanje sajtovima</li>
                                <li>Dodavanje domena</li>
                                <li>Praćanje statistike</li>
                                <li>Najbolje rešenje</li>
                            </ul>
                            
                            <h3 class="paragraph-title"><span class="fa fa-bar-chart"></span>Statistika</h3>
    
                            <ul class="check-list">
                                <li>Web stats</li>
                                <li>Webalizer</li>
                                <li>Awstat</li>
                                <li>Google analytics (na zahtev)</li>
                            </ul>
                            
                            <h3 class="paragraph-title"><span class="fa fa-upload"></span>FTP</h3>
    
                            <ul class="check-list">
                                <li>FTP pristup</li>
                                <li>File manager</li>
                                <li>Error stranice</li>
                            </ul>
                            
                            <h3 class="paragraph-title"><span class="fa fa-user"></span>Managed usluge</h3>
    
                            <ul class="check-list">
                                <li>3 sata 40 eur (važi naredna 3 meseca od datuma kupovine)</li>
                                <li>5 sati 50 eur (važi narednih 5 meseci od datuma kupovine)</li>
                                <li>10 sati 80 eur (važi narednih 10 meseci od datuma kupovine)</li>
                            </ul>
                            
                            <h3 class="paragraph-title"><span class="fa fa-user-plus"></span>Dodatne usluge</h3>
    
                            <ul class="check-list">
                                <li>Dodatna IP adresa</li>
                                <li>SSL sertifikat</li>
                                <li>Instalacija CMS po potrebi</li>
                            </ul>
                            
                            <h3 class="paragraph-title"><span class="fa fa-envelope"></span>E-Mail</h3>
    
                            <p>Svaki korisnik dobija svoju email adresu sa imenom po izboru. E-mail se vrlo lako konfiguriše preko poznatih email klijenata a pristup je obezbedjen i preko webmaila putem našeg sajta.</p>
    
                            <ul class="check-list">
                                <li>POP3/ SMTP pristup</li>
                                <li>WebMail pristup</li>
                                <li>Automatsko odgovaranje na primljen mail</li>
                                <li>Prosledjivanje svakog primljenog maila</li>
                                <li>Boxtrapper zaštita</li>
                                <li>Spam zaštita</li>
                            </ul>
                            
                            '
                ],
                'en' => [
                    'title' => 'Technical characteristics',
                    'content' => '
                            
                            <h3 class="paragraph-title"><span class="fa fa-cloud"></span>cPanel software</h3>
    
                            <ul class="check-list">
                                <li>PHP version 4.4 -7.2</li>
                                <li>Perl</li>
                                <li>GD Library</li>
                                <li>Imagemanager</li>
                                <li>Optimize website</li>
                                <li>Virusscaner</li>
                                <li>Cronjob</li>
                            </ul>
                            
                            <h3 class="paragraph-title"><span class="fa fa-bar-chart"></span>Statistics</h3>
    
                            <ul class="check-list">
                                <li>Web stats</li>
                                <li>Webalizer</li>
                                <li>Awstat</li>
                                <li>Google analytics (on request)</li>
                            </ul>
                            
                            
                            <h3 class="paragraph-title"><span class="fa fa-envelope"></span>E-Mail</h3>
    
                            <ul class="check-list">
                                <li>POP3/ SMTP pristup</li>
                                <li>WebMail access</li>
                                <li>Automatically reply to received mail</li>
                                <li>Forward each received mail</li>
                                <li>Boxtrapper protection</li>
                                <li>Spam protection</li>
                            </ul>
                            '
                ],
            ],
        ];

        return view('offers.hosting', compact(['offer', 'headTitle']));
    }

    public function getSsdHostingOffer(Request $request)
    {
        $route = $request->route()->getName();
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Ultra Brz SSD Hosting - Najbolja Cena u Srbiji' : 'European SSD hosting';

        $product_line = ProductLineRepository::getByCode('ssd-hosting');
        $products = ProductRepository::getByProductLine($product_line->id);
        $products = $products->take(4);

        $billingType = $product_line->billing_type;
        if(empty($billingType)) {
            $billingType = $product_line->productCategory->billing_type;
        }

        $offer = new CommonOffer($product_line->name, $route);
        $offer->titleHtml = '<span class="c-yellow">' . $product_line->name . '</span>';
        $offer->description = $product_line->description;
        $offer->items = $products;
        $offer->colspan = $this->colSpan(count($offer->items));
        $offer->cartRoute = 'cart.hosting';
        $offer->billingType = trans('main.' . $billingType);

        $offer->tabs = [
            'tab_1' => [

                'sr-Latn' => [
                    'title' => 'Informacije',
                    'content' => '<h3 class="paragraph-title"><span class="fa fa-bar-chart"></span>SSD performanse</h3>
                            
                            <p>Razumemo važnost brzog učitavnja Vašeg sajta. Naši 10-cores Xeon hosting serveri omogućavaju do 300% brže učitavanje stranice od standardnog hostinga .</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-bolt"></span>LiteSpeed</h3>
                            <p>Isprobajte super moć LiteSpeed web servera! Učiniće Vaš sajt višestruko bržim! LiteSpeed je zamena za Apache web server i ima visok učinak, siguran je i jednostavan za upotrebu. LiteSpeed-ova ugrađena keš memorija na nivou servera (LSCache) je visoko prilagodljivo rešenje keširanja. Uz LSCache se dramatično smanjuje vreme učitavanja stranice, uspešno izlazi na kraj sa velikim saobraćajem i LSCache plugin-ovi su dostupni besplatno za najpopularnije web aplikacije.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-shield"></span>ImunifyAV+</h3>
                            <p>Pomaže Vašem sajtu, skenira i uklanja zlonameran sadržaj. Potpuno besplatno koristite ovaj dodatak kroz cPanel i dodatno zaštitite Vaš sajt.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-line-chart"></span>Veći protok</h3>
                            <p>Mesečni protok se udvostručuje u odnosu na paket SSD Web Hosting. U praksi, to znači da će naši hosting paketi biti dovoljni za sajtove sa do 500,000 poseta mesečno.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-shopping-cart"></span>Idealno za online prodavnice</h3>
                           
                            <p>Prebacivanjem na SSD hosting, web prodavnica ili blog će se učitati brže, što će automatski doprineti boljoj stopi konverzije i boljem položaju u pretraživaču. Jedan od važnih faktora koji Google uzima u obzir u smislu rangiranja je web brzina, a SSD ovde nema konkurencije.
                            </p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-refresh"></span>cPanel</h3>
                            <P>Najpoznatije rešenje za upravljanje web hosting paketima. Lako i poznato okruženje. Dodajte nove web hosting pakete ili kreirajte e-mail adrese.</P>
                            
                            <h3 class="paragraph-title"><span class="fa fa-battery"></span>Vraćamo novac ako niste zadovoljni</h3>
                            <p>
                            Smatramo da je 30 dana dovoljno da se uverite u kvalitet naših usluga. Klijenti koji iz nekog razloga ne žele da i dalje koriste naš hosting dobiće svoj novac nazad, bez pitanja.
                            </p>'


                ],
                'en-Latn' => [
                    'title' => 'Why Webglobe hosting?',
                    'content' => '<h3 class="paragraph-title"><span class="fa fa-certificate"></span>SSL</h3>
                            
                            <p>Each user receives a free Comodo SSL for all of their domains.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-user"></span>Support</h3>
                            <p>We are recognizable by customer support that does not leave any problems unresolved. For the most common questions, we made a knowledge base available to everyone.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-refresh"></span>Regular backup</h3>
                            <p><img style="height: 50px" src="' . url('images/spublisher.png') . '" alt=""> <br><br>
                            We know how important it is for users to have the last copy of their site. The backup is done on a daily, weekly and monthly basis.
                            </p>'
                ],
                'en' => [
                    'title' => 'Info',
                    'content' => '<h3 class="paragraph-title"><span class="fa fa-bar-chart"></span>SSD performance</h3>
                            
                            <p>We understand the importance of fast loadingof your website. Our SSD 10-cores Xeon hosting servers allow you up to 300% faster page loading than standard hosting.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-bolt"></span>LiteSpeed</h3>
                            <p>Try the super power of the LiteSpeed web server! It will make your site much faster! LiteSpeed is the most popular replacemnet for Apache - high performace, secure and easy to use web server. LiteSpeeds built-in server-level cache (LSCache) is a highly-customizable caching solution. With LSCache, you can reduce page load time, handle traffic spikes successfully and LSCache plugins, use for free, are available for a variety of popular web apps.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-shield"></span>ImunifyAV+</h3>
                            <p>Helps your site, scans and removes malicious content. Use this add-on completely free through cPanel and protect your site.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-line-chart"></span>Far greater flow</h3>
                            <p>The monthly flow rate is doubled compared to the SAS Web Hosting package. In practice, this means that our hosting packages will be sufficient for the sites with up to 500,000 visits per month.</p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-shopping-cart"></span>Ideal for online stores</h3>
                            <p>Switching to SSD Hosting,your web store or blog will load faster, which will automatically contribute to a better conversion rate and a better position on the search engine. One of the important factors that Google takes into account in terms of ranking is the websitespeed, and SSD has no competition here.
                            </p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-battery"></span>Money Return</h3>
                            <p>
                            We believe 30 days is just enough for you to make sure of the quality of our services. The clients who do not want to keep the Webglobe hosting packages for some reason, will get their money back, without explanations.
                            </p>
                            
                            <h3 class="paragraph-title"><span class="fa fa-refresh"></span>cPanel</h3>
                            <p>The world\'s best-known solution for managing web hosting packages. Easy and familiar environment. Add new web hosting packages or open email addresses</p>'
                ],
            ],

            'tab_2' => [
                'sr-Latn' => [
                    'title' => 'Podrška',
                    'content' => '<p>Znamo koliko je bitno da korisnici imaju poslednju kopiju svog sajta. Bekap se radi na dnevnom, nedeljnom i mesečnom nivou. Posedujemo najsavremenija rešenja u pogledu sigurnosti servera. Koristimo SSL enkripciju, a posebnu pažnju poklanjamo bezbednosti korisnika.</p>

                        <p>U sve to spadaju:</p>
                        <ul class="check-list">
                            <li>Direktorijumi zaštićeni lozinkom</li>
                            <li>Error log</li>
                            <li>Hotlink zaštita</li>
                            <li>Leech zaštita</li>
                            <li>GnuPG keys</li>
                            <li>Radudantni link od strane 3 provajdera</li>
                        </ul>
                        
                        <h3 class="paragraph-title"><span class="fa fa-user"></span>Korisnička podrška</h3>
                        
                        <p>Znamo da ne možete sve sami i zato smo mi tu. Pored standardne pomoći klijentima. Podršku pružamo preko tiketing sistema i telefona svakog dana od 08-20 h.</p>
                        <p>Webglobe tehnička podrška je na rapolaganju za:</p>
                        
                        <ul>
                            <li>Besplatnu migraciju sajta sa drugog hosting naloga</li>
                            <li>Besplatnu instalaciju CMSa po želji</li>
                            <li>Konsultacije oko izbora dodataka i njihovu instalaciju</li>
                            <li>Baza znanja sa uputstvima</li>
                        </ul>
                        
                        <h3 class="paragraph-title"><span class="fa fa-refresh"></span>Redovan backup</h3>
                        <p>Znamo koliko je bitno da korisnici imaju poslednju kopiju svog sajta. Bekap se radi na dnevnom, nedeljnom i mesečnom nivou.</p>
                        ',
                ],
                'en' => [
                    'title' => 'Additional services',
                    'content' => '<h3 class="paragraph-title">Additional managed service</h3>
                                
                                <ul class="check-list">
                                    <li>54 EUR per hour</li>
                          
                                </ul>
                                
                                <h3 class="paragraph-title">Free SSL Certificate</h3>
                                
                                <p><img src="' . url('images/autossl1.png') . '" style="height: 50px" alt=""> <br><br>
                                All users of Webglobe Hosting can have free of charge a Comodo SSL certificate within a hosting package. All you need is to activate it.
                                </p>
                                
                                <h3 class="paragraph-title">Cloudflare</h3>
                                <p>Install completely free CloudFlare through CPanel</p>
                                
                                <h3 class="paragraph-title">HTTP/2</h3>
                                <p>All our hosting packages are HTTP / 2 compatible. If your speed is important - we are your choice!</p>
                                
                            '
                ]
            ],
        ];

        return view('offers.hosting', compact(['offer', 'headTitle']));
    }

    public function getMailServersOffer(Request $request)
    {
        $route = $request->route()->getName();
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Mail Serveri' : 'Mail Servers';

        $product_line = ProductLineRepository::getByCode('mail-servers');
        $products = ProductRepository::getByProductLine($product_line->id);
        $products = $products->take(4);

        $billingType = $product_line->billing_type;
        if(empty($billingType)) {
            $billingType = $product_line->productCategory->billing_type;
        }

        $offer = new CommonOffer($product_line->name, $route);
        $offer->titleHtml = '<span class="c-yellow">' . $product_line->name . '</span>';
        $offer->description = $product_line->description;
        $offer->items = $products;
        $offer->colspan = $this->colSpan(count($offer->items));
        $offer->cartRoute = 'cart.hosting';
        $offer->billingType = trans('main.' . $billingType);

        return view('offers.hosting', compact(['offer', 'headTitle']));
    }

    public function colSpan($itemsCount)
    {
        if($itemsCount == 0) return null;

        if($itemsCount === 1) {
            return [
                'span' => 4,
                'offset' => 4,
            ];
        } else {
            $length = 12;
            if ($length % $itemsCount == 0) {
                return [
                    'span'   => $length / $itemsCount,
                    'offset' => 0
                ];
            } else {
                $colspan = (int)floor($length / $itemsCount);
                $offset = ($length - $colspan * $itemsCount) / 2;
                return [
                    'span'   => $colspan,
                    'offset' => $offset,
                ];
            }
        }
    }
}
