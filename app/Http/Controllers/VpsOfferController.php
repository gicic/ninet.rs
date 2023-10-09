<?php

namespace App\Http\Controllers;

use App\CommonOffer;
use App\Repositories\ProductLineRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class VpsOfferController extends Controller
{
    public function getSsdVpsCpanelOffer(Request $request)
    {
        $route = $request->route()->getName();
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'SSD VPS cPanel' : 'SSD VPS cPanel';

        $product_line = ProductLineRepository::getByCode('ssd-vps-cpanel');
        $products = ProductRepository::getByProductLine($product_line->id);

        $billingType = $product_line->billing_type;
        if(empty($billingType)) {
            $billingType = $product_line->productCategory->billing_type;
        }

        $offer = new CommonOffer($product_line->name, $route);
        $offer->titleHtml = '<span class="c-yellow">' . $product_line->name . '</span>';
        $offer->description = \App::getLocale() === 'sr-Latn' ? '' : '';
        $offer->items = $products;
        $offer->colspan = $this->colSpan(count($offer->items));
        $offer->cartRoute = 'cart.vps';
        $offer->billingType = trans('main.' . $billingType);

        $offer->tabs = [];
        $offer->tabs = [
            'tab_1' => [
                'sr-Latn' => [
                    'title' => 'Informacije',
                    'content' => '<p>Priključeni na brzi Internet link, kako bi svaki od servera davao svoj maksimum u pogledu performansi i dostupnosti velikih i posećenih sajtova</p>
                                    <p>Bez obzira da li ste koristili naše servere do sada ili ne, naša korisniška podrška Vam stoji na raspolaganju. Čak i ako prenosite sajt sa našeg shared hostinga, doplatićete samo razliku u ceni</p>
                                    <p>Moćni VPS serveri namenjeni korisnicima koji žele veću fleksibilnost u radu, po najboljim cenama u Srbiji. Predstavljaju odlično rešenje za korisnike kojima shared hosting nije dovoljan i koji istovremeno nemaju potrebu za namenskim serverima.</p>
                                    <p>Garantujemo kvalitet i najpristupačnije cene u regionu.</p>
                    '
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

            'tab_4' => [
                'sr-Latn' => [
                    'title' => 'Česta pitanja',
                    'content' => '

                            <ul class="check-list">
                                <li>
                                Ko koristi VPS servere i zašto? <br>
                                VPS je našao široku primenu kod programera i web dizajnera koji imaju velike sajtove ili web aplikacije i najbolje je rešenje za one kojima shared hosting predstavlja ograničenje u poslovanju a još uvek nemaju potrebu za namenskim serverima.
                                </li>
                                <li>
                                Da li mogu da se prebacim na veći paket? <br>
                                Da , moguće je da se prebacite na veći paket ukoliko se pokaže da su Vam postojeća  rešenja nedovoljna. Svi fajlovi koji se nalaze na serveru ostaju na njemu.
                                </li>
                                <li>
                                Kako se plaćaju VPS serveri? <br>
                                Najčešće  se klijenti odlučuju  da plaćaju "mesec za mesec" ali za veći broj meseci odobravamo popust. Povremeno imamo i akcije za nove korisnike. Za uplatu servera iz inostranstva koristite englesku verziju sajta.</li>
                                <li>
                                Da li VPS mogu da koristim kao game hosting? <br>
                                Ne, za game hosting i instalaciju game skripti pogledajte opciju namenskih servera.</li>
                                <li>
                                Da li mi možete pomoći oko instalacije VPS servera? <br>
                                Da, instalacija OS-a se podrazumeva a takođe Vam je na raspolaganju i full managed usluga održavanja servera.</li>
                                <li>
                                Da li mogu da testiram VPS pre nego što ga kupim? <br>
                                Da, daćemo vam VPS server na period od 3 dana kako biste se uverili u kvalitet i brzinu naših servera. Potrebno je da nam pošaljete Vaše tačne podatke.</li>
                                <li>
                                Da li mogu da ostvarim popust? <br>
                                Za specifične zahteve nam se obratite preko tiketing servisa kako biste našli najoptimalnije rešešenje za Vaš novi virtualni server. Pri naručivanju servera na 5 illi 10 meseci dobijate besplatan 1 odnosno 2 meseca.</li>
                                <li>
                                Kako se pruža podrška? <br>
                                Možete nas kontaktirati u vezi sa bilo kojim pitanjem preko ticketing sistema ili u hitnim slučajevima na telefon 018/34-09-888 .</li>
                            </ul>
                            '
                ],


                ],

        ];

        return view('offers.common', compact(['offer', 'headTitle']));
    }

    public function getSsdVpsOffer(Request $request)
    {
        $route = $request->route()->getName();
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Brzi SSD VPS već od 14 eur /mes' : 'SSD Servers Europe';

        $product_line = ProductLineRepository::getByCode('ssd-vps');
        $products = ProductRepository::getByProductLine($product_line->id);

        $billingType = $product_line->billing_type;
        if(empty($billingType)) {
            $billingType = $product_line->productCategory->billing_type;
        }

        $offer = new CommonOffer($product_line->name, $route);
        $offer->titleHtml = '<span class="c-yellow">' . $product_line->name . '</span>';
        $offer->description = $product_line->description;
        $offer->items = $products;
        $offer->colspan = $this->colSpan(count($offer->items));
        $offer->cartRoute = 'cart.vps';
        $offer->billingType = trans('main.' . $billingType);

        $offer->tabs = [
            'tab_1' => [
                'sr-Latn' => [
                    'title' => 'Zašto Webglobe SSD VPS?',
                    'content' => '
                        <h3 class="paragraph-title"><span class="fa fa-server"></span>Domaći data cetar</h3>
                        <p>Svi VPS serveri nalaze se u Srbiji što znači da sajtovi koji ih koriste imaju brži odziv nego sajtovi koji koriste inostrane servere.</p>
                        <p>Sami vodimo računa o našim resursima i to radimo uspešno već 15 godina.</p>
                        
                        <h3 class="paragraph-title"><span class="fa fa-user-md"></span>Fantastična korisnička podrška</h3>
                        <p>Stručno osoblje spremno čeka na Vaš sledeći poziv. Svaki zahtev, problem ili sugestiji rešavamo rekordno brzo.</p>
                        <p>Vreme odgovaranja na tiket je manje od 1h u proseku.</p>
                        <p>Garantujemo dostupnost VPS servera 99,98% na godišnjem nivou.</p>
                       
                        <h3 class="paragraph-title"><span class="fa fa-dashboard"></span>Odlične performanse</h3>
                        
                        <ul class="check-list">
                            <li>VPS serveri su bazirani na vrhunskoj hardverskoj arhitekturi</li>
                            <li>Priključeni na brži Internet link,i samo kod nas u osnovnoj varijanti kod SSD VPS XXL imamo u ponudi garantovani link od 200Mb/sec.</li>
                            <li>Svaki SSD VPS, pored Solus VM kontrolnog panela, podrazumeva instalaciju Linux operativnog sistema, potpun root pristup i podešavanje servera preko SSH.</li>
                            <li>Brzina i do 1 GB/s na zahtev klijenata</li>
                        </ul>
                    '
                ],
                'en' => [
                    'title' => 'Info',
                    'content' => '
                        <h3 class="paragraph-title"><span class="fa fa-money"></span>Best Price</h3>
                        <p>All VPS SSD packages are created to address even the most demanding clients, with no additional costs <strong>(free backup, panel and support)</strong></p>
                        
                        <h3 class="paragraph-title"><span class="fa fa-user-md"></span>Excellent Support</h3>
                        <p>Professionals of Webglobe Company are ready for your call. Any request, issue or suggestion will be solved at shortest notice. The average time for responding to a ticket is less than 1 hour.</p>
                        
                        <h3 class="paragraph-title"><span class="fa fa-line-chart"></span>Performances</h3>
                        <p>For our VPS hosting packages, we have selected the ultimate equipment in accordance with the highest standards in the industry. Thanks to SSD technology, your website or application will be working much faster than with standard VPS standards.</p>
                                            
                        <h3 class="paragraph-title"><span class="fa fa-cloud"></span>Cloudflare</h3>
                        <p>Use the advantages of CloudFlare technology. The content at you server will have the same performances independent of where your visitors come from, USA, EU or Australia.</p>
                    '
                ]
            ],

            'tab_4' => [
                'sr-Latn' => [
                    'title' => 'Česta pitanja',
                    'content' => '
                        <strong><em>Ko koristi VPS servere i zašto?</em></strong> <br>
                        VPS je našao široku primenu kod programera i web dizajnera koji imaju velike sajtove ili web aplikacije i najbolje je rešenje za one kojima shared hosting predstavlja ograničenje u poslovanju a još uvek nemaju potrebu za namenskim serverima. <br><br>
                        
                        <strong><em>Da li mogu da se prebacim na veći paket?</em></strong> <br>
                        Da , moguće je da se prebacite na veći paket ukoliko se pokaže da su Vam postojeca rešenja nedovoljna. Svi fajlovi koji se nalaze na serveru ostaju na njemu. <br><br>
                        
                        <strong><em>Kako se plaćaju VPS serveri?</em></strong> <br>
                        Najcešce se klijenti odlucuju da plaćaju "mesec za mesec" ali za veći broj meseci odobravamo popust. Povremeno imamo i akcije za nove korisnike. Za uplatu servera iz inostranstva koristite englesku verziju sajta. <br><br>
                        
                        <strong><em>Da li VPS mogu da koristim kao game hosting?</em></strong> <br>
                        Ne, za game hosting i instalaciju game skripti pogledajte opciju namenskih servera. <br><br>
                        
                        <strong><em>Da li mi možete pomoći oko instalacije VPS servera?</em></strong> <br>
                        Da, instalacija OS-a se podrazumeva a takođe Vam je na raspolaganju i full managed usluga održavanja servera. <br><br>
                        
                        <strong><em>Da li mogu da testiram VPS pre nego što ga kupim?</em></strong> <br>
                        Da, daćemo vam VPS server na period od 3 dana kako bi se uverili u kvalitet i brzinu naših servera. Potrebno je da nam pošaljete Vaše tačne podatke <br><br>
                        
                        <strong><em>Da li mogu da ostvarim popust?</em></strong> <br>
                        Za specifične zahteve nam se obratite preko ticketing servisa kako bi našli najoptimalnije rešešenje za Vaš novi virtualni server. Pri naručivanju servera na 5 illi 10 meseci dobijate besplatan 1 odnosno 2 meseca. <br><br>
                        
                        <strong><em>Kako se pruža podrška?</em></strong> <br>
                        Možete nas kontaktirati u vezi bilo kog pitanja preko ticketing Sistema ili u hitnim slučajevima na telefon 018/34-09-888 . <br><br>         
                            '
                ],
            ],
        ];

        return view('offers.common', compact(['offer', 'headTitle']));
    }

    public function colSpan($itemsCount)
    {
        if($itemsCount == 0) return null;

        $length = 12;
        if($length % $itemsCount == 0) {
            return [
                'span' => $length / $itemsCount,
                'offset' => 0
            ];
        } else {
            $colspan = (int)floor($length / $itemsCount);
            $offset = ($length - $colspan * $itemsCount) / 2;
            return [
                'span' => $colspan,
                'offset' => $offset,
            ];
        }
    }

    public function getVpsWindowsSsdOffer (Request $request)
    {
        {
            $route = $request->route()->getName();
            $headTitle = \App::getLocale() === 'sr-Latn' ? 'Brzi SSD VPS već od 14 eur /mes' : 'SSD Servers Europe';
            $product_line = ProductLineRepository::getByCode('vps-windows-ssd');
            $products = ProductRepository::getByProductLine($product_line->id);

            $billingType = $product_line->billing_type;
            if(empty($billingType)) {
                $billingType = $product_line->productCategory->billing_type;
            }

            $offer = new CommonOffer($product_line->name, $route);
            $offer->titleHtml = '<span class="c-yellow">' . 'VPS Windows SSD' . '</span>';
            $offer->description = 'VPS Windows SSD';
            $offer->items = $products;
            $offer->colspan = $this->colSpan(count($offer->items));
            $offer->cartRoute = 'cart.vps';
            $offer->billingType = trans('main.' . $billingType);

//            $offer->tabs = [
//                'tab_1' => [
//                    'sr-Latn' => [
//                        'title' => 'Zašto NiNet SSD VPS?',
//                        'content' => '
//                        <h3 class="paragraph-title"><span class="fa fa-server"></span>Domaći data cetar</h3>
//                        <p>Svi VPS serveri nalaze se u Srbiji u NiNet-ovom data centru, što znači da sajtovi koji koriste NiNet VPS imaju brži odziv nego oni koji se nalaze u drugim zemljama.</p>
//                        <p>Sami vodimo računa o našim resursima, i to radimo uspešno već 15 godina.</p>
//
//                        <h3 class="paragraph-title"><span class="fa fa-user-md"></span>Fantastična korisnička podrška</h3>
//                        <p>Stručno osoblje NiNet Company spremno čeka na Vaš sledeći poziv. Svaki zahtev, problem ili sugestiji rešavamo rekordno brzo.</p>
//                        <p>Vreme odgovaranja na tiket je manje od 1h u proseku.</p>
//                        <p>Garantujemo dostupnost VPS servera 99,98% na godišnjem nivou. U našem data centru koristimo najsavremenija rešenja za bezbednost i monitoring.</p>
//
//                        <h3 class="paragraph-title"><span class="fa fa-dashboard"></span>Odlične performanse</h3>
//
//                        <ul class="check-list">
//                            <li>NiNet SSD VPS serveri su bazirani na vrhunskoj hardverskoj arhitekturi, isključivo HP ProLiant DL serverima i procesorima (Xeon core4 ili core 6).</li>
//                            <li>Priključeni na brži Internet link,i samo kdo nas u osnovnoj varijanti kod SSD VPS XXL imamo u ponudi garantovani link od 200Mb/sec.</li>
//                            <li>Svaki SSD VPS, pored Solus VM kontrolnog panela, podrazumeva instalaciju Linux operativnog sistema, potpun root pristup i podešavanje servera preko SSH.</li>
//                            <li>Brzina i do 1 GB/s na zahtev klijenata</li>
//                        </ul>
//
//                        <h3 class="paragraph-title"><span class="fa fa-dashboard"></span>Deo smo velikih sistema</h3>
//
//                        <ul class="check-list">
//                            <li>Deo smo Serbian Open Exchange-a (SOX)</li>
//                            <li>U saradnji sa Elektronskim fakultetom pokrenuli smo i Naissix, lokalnu nezavisnu tačku razmene internet saobraćaja u Nišu i postali smo sastavni deo čvorišta.</li>
//                            <li>Iskoristite prednosti CloudFlare tehnologije! Sadržaj na Vašem serveru imaće iste performanse bez obzira da li su Vaši posetioci iz USA, EU ili Australije.</li>
//                        </ul>
//                    '
//                    ],
//                    'en' => [
//                        'title' => 'Info',
//                        'content' => '
//                        <h3 class="paragraph-title"><span class="fa fa-money"></span>Best Price</h3>
//                        <p>All NiNet VPS SSD packages are created to address even the most demanding clients, with no additional costs <strong>(free backup, panel and support)</strong></p>
//
//                        <h3 class="paragraph-title"><span class="fa fa-user-md"></span>Excellent Support</h3>
//                        <p>Professionals of NiNet Company are ready for your call. Any request, issue or suggestion will be solved at shortest notice. The average time for responding to a ticket is less than 1 hour.</p>
//
//                        <h3 class="paragraph-title"><span class="fa fa-line-chart"></span>Performances</h3>
//                        <p>For our VPS hosting packages, we have selected the ultimate equipment in accordance with the highest standards in the industry. Thanks to SSD technology, your website or application will be working much faster than with standard VPS standards.</p>
//
//                        <h3 class="paragraph-title"><span class="fa fa-dashboard"></span>Speed</h3>
//                        <p>From all Serbian providers, NiNet Company is the only one offering their clients the port speed up to 200Mbps. For the projects requiring higher speed than the above, please contact our Support.</p>
//
//                        <h3 class="paragraph-title"><span class="fa fa-cloud"></span>Cloudflare</h3>
//                        <p>Use the advantages of CloudFlare technology. The content at you server will have the same performances independent of where your visitors come from, USA, EU or Australia.</p>
//
//                        <h3 class="paragraph-title"><span class="fa fa-users"></span>SOX I Naissix partners</h3>
//                        <p>We are a part of Serbian Open Exchange (SOX), a regional platform for exchange of Internet traffic. Also, in cooperation with the Faculty of Electronical Engineering we have launched Naissix, a local independent point of Internet traffic exchange in Nis.</p>
//
//                    '
//                    ]
//                ],
//
//                'tab_2' => [
//                    'sr-Latn' => [
//                        'title' => 'Paneli',
//                        'content' => '
//                        <h3 class="paragraph-title">SolusVM</h3>
//                        <ul class="check-list">
//                            <li>Pregledan</li>
//                            <li>Potpuna kontrola kod uključivanja i isključivanja servera</li>
//                            <li>Promena šifre</li>
//                            <li>Grafički prikaz performansi i zauzetosti resursa</li>
//                            <li>Prilagođavajući administracioni deo</li>
//                            <li>Kompatabilan i lak za rukovanje sa poznatim softverskim rešenjima</li>
//                            <li> I najvažnije: Samo u <strong>NiNetu potpuno besplatan</strong></li>
//                        </ul>
//
//                        <h3 class="paragraph-title">cPanel</h3>
//                        <ul class="check-list">
//                            <li>Nije Vam potreban administrator</li>
//                            <li>Hostujete neograničen broj sajtova</li>
//                            <li>Već je poznato okruženje u kome se nalazite</li>
//                            <li>Pratite naprednu statistiku i performanse</li>
//                            <li>Besplatna instalacija</li>
//                        </ul>
//                        ',
//                    ],
//                    'en' => [
//                        'title' => 'Panels',
//                        'content' => '
//                        <h3 class="paragraph-title">CPanel license</h3>
//                        <ul class="check-list">
//                            <li>cPanel license</li>
//                            <li>CPanel solor  (for 1 domain only)</li>
//                            <li>Free Comodo SSL</li>
//                            <li>Familiar environment</li>
//                            <li>Unlimited web hosting packages</li>
//                        </ul>
//
//                        <h3 class="paragraph-title">Solus VM</h3>
//                        <p>All clients get access to SolusVM to easily manage their server. Some of SolusVM options are: </p>
//                        <ul class="check-list">
//                            <li>VPS restart</li>
//                            <li>Password change</li>
//                            <li>Statistics overview</li>
//                            <li>Hostname change</li>
//                            <li>Logs overview</li>
//                        </ul>
//                    '
//                    ]
//
//                ],
//
//                'tab_3' => [
//                    'sr-Latn' => [
//                        'title' => 'Dodatne usluge',
//                        'content' => '
//
//                            <ul class="check-list">
//                                <li>Dodatni protok: 1 TB - 10 eur/ mes</li>
//                                <li>SSL sertifikat već od 19 eur mesečno</li>
//                                <li>IP adresa - 3 eur/ mes</li>
//                                <li>Cpanel - 15 eur /mes</li>
//                            </ul>
//
//                            <h3 class="paragraph-title"><span class="fa fa-clock-o"></span>Dodatni sati Managed usluge</h3>
//
//                            <ul class="check-list">
//                                <li>3 sata 40 eur/mesečno</li>
//                                <li>5 sati 50 eur/mesečno</li>
//                                <li>5 sati 50 eur/mesečno</li>
//                            </ul>
//                            '
//                    ],
//                ],
//
//                'tab_4' => [
//                    'sr-Latn' => [
//                        'title' => 'Česta pitanja',
//                        'content' => '
//                        <strong><em>Ko koristi VPS servere i zašto?</em></strong> <br>
//                        VPS je našao široku primenu kod programera i web dizajnera koji imaju velike sajtove ili web aplikacije i najbolje je rešenje za one kojima shared hosting predstavlja ograničenje u poslovanju a još uvek nemaju potrebu za namenskim serverima. <br><br>
//
//                        <strong><em>Da li mogu da se prebacim na veći paket?</em></strong> <br>
//                        Da , moguće je da se prebacite na veći paket ukoliko se pokaže da su Vam postojeca rešenja nedovoljna. Svi fajlovi koji se nalaze na serveru ostaju na njemu. <br><br>
//
//                        <strong><em>Kako se plaćaju VPS serveri?</em></strong> <br>
//                        Najcešce se klijenti odlucuju da plaćaju "mesec za mesec" ali za veći broj meseci odobravamo popust. Povremeno imamo i akcije za nove korisnike. Za uplatu servera iz inostranstva koristite englesku verziju sajta. <br><br>
//
//                        <strong><em>Da li VPS mogu da koristim kao game hosting?</em></strong> <br>
//                        Ne, za game hosting i instalaciju game skripti pogledajte opciju namenskih servera. <br><br>
//
//                        <strong><em>Da li mi možete pomoći oko instalacije VPS servera?</em></strong> <br>
//                        Da, instalacija OS-a se podrazumeva a takođe Vam je na raspolaganju i full managed usluga održavanja servera. <br><br>
//
//                        <strong><em>Da li mogu da testiram VPS pre nego što ga kupim?</em></strong> <br>
//                        Da, daćemo vam VPS server na period od 3 dana kako bi se uverili u kvalitet i brzinu naših servera. Potrebno je da nam pošaljete Vaše tačne podatke <br><br>
//
//                        <strong><em>Da li mogu da ostvarim popust?</em></strong> <br>
//                        Za specifične zahteve nam se obratite preko ticketing servisa kako bi našli najoptimalnije rešešenje za Vaš novi virtualni server. Pri naručivanju servera na 5 illi 10 meseci dobijate besplatan 1 odnosno 2 meseca. <br><br>
//
//                        <strong><em>Kako se pruža podrška?</em></strong> <br>
//                        Možete nas kontaktirati u vezi bilo kog pitanja preko ticketing Sistema ili u hitnim slulajevima na telefon 018/41-55-055. <br><br>
//
//                            '
//                    ],
//                ],
//            ];

            return view('offers.common', compact(['offer', 'headTitle']));
        }

    }
}
