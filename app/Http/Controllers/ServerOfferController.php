<?php

namespace App\Http\Controllers;

use App\CommonOffer;
use App\Repositories\ProductLineRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ServerOfferController extends Controller
{

    public function getLinuxOffer(Request $request)
    {
        $route = $request->route()->getName();
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Dedicated Serveri u Srbiji - samo 69 eur mesečno </span>' : 'Dedicated Servers Europe 1 Gbps <br> <span class="c-yellow">Promo code: <strong>serveri</strong></span>';

        $product_line = ProductLineRepository::getByCode('linux-servers');
        $products = ProductRepository::getByProductLine($product_line->id);
        $products = $products->take(4);

        $billingType = $product_line->billing_type;
        if(empty($billingType)) {
            $billingType = $product_line->productCategory->billing_type;
        }

        $offer = new CommonOffer($product_line->name, $route);
        $offer->titleHtml = '<span class="c-yellow">' . $product_line->name . '</span>';
        $offer->description = '<strong>' . $product_line->description . '</strong>';
        $offer->items = $products;
        $offer->colspan = $this->colSpan(count($offer->items));
        $offer->cartRoute = 'cart.linux-servers';
        $offer->billingType = trans('main.' . $billingType);

        $offer->tabs = [
            'tab_1' => [
                'sr-Latn' => [
                    'title' => 'Zašto Webglobe serveri?',
                    'content' => '<h3 class="paragraph-title">Pristupačne cene</h3>
                                    <p>IInicijalno podešavanje servera kod nas je besplatan. Cene naših dedicated servera su u odnosu na performanse među najboljim u regionu.</p>
                                    
                                    <h3 class="paragraph-title">Brzina</h3>
                                    
                                    <p>Koristimo dodatni link što znači da se u slučaju prekida rada jednog od njih aktiviraju sekundarni izvori napajanja što obezbeđuje nesmetan rad sistema. Garantujemo do 99,9% dostupnosti na godišnjem nivou.Maksimalna brzina je 1 Gbps

                                    
                                    Garantujemo do 99,9% dostupnosti na godišnjem nivou.</p>
                                    <p>Maksimalna brzina je 1 Gbps</p>

                                    <h3 class="paragraph-title">Sloboda i nezavisnost u radu</h3>
                                    
                                    <p>Za razliku od VPS i shared hostinga, korisnici dedicated servera su u mogućnosti da budu sami na serveru bez deljenja resursa sa drugima. Vi potpuno kontrolišete rad servera, sve web aplikacije, sajtove ili email server</p>
                                    
                                    <h3 class="paragraph-title">Partnerski pristup</h3>
                                    
                                    <p>Shvatamo da je svaki biznis poseban, a u skladu sa tom činjenicom i Vaši zahtevi. Ukoliko u zvaničnoj ponudi niste pronašli ono što Vam odgovara - kontaktirajte nas. Otvoreni smo za svaku vrstu dogovora. Zakazaćemo konferencijski sastanak sa našim administratorima i prodajom kako bismo najbrže došli do rešenja.</p>
                                   
                                    
                                    ',
                ],
                'en' => [
                    'title' => 'Info',
                    'content' => '<h3 class="paragraph-title">Independence in operation</h3>
                                    <p>Unlike VPS and shared hosting, dedicated server allow users to be alone on the server without sharing the resources with others. You completely in the control of your server operations, all web applications, websites or the email server.</p>
                                    
                                    <h3 class="paragraph-title">Reliable Servers</h3>
                                    
                                    <p>We use the redundant link from the 3 largest providers, meaning that in a case of termination of one of them, the secondary source will activate which secures uninterrupted operation of the system. All servers are under, with the 24/7 monitoring, with Intel <strong>Xeon</strong> processors  hardware solutions. We guarantee up to 99.9% of the guaranteed time.</p>
                                    
                                    <h3 class="paragraph-title">Cost-effectiveness and Price</h3>
                                    
                                    <p>We have the best regional offer. Clients who opt to buy dedicated servers are free to keep their websites or web applications. We offer discounts to already attractive prices for the clients who opt for the semi-annual or annual lease.</p>
                                    
                                    <h3 class="paragraph-title">Customer Support</h3>
                                    
                                    <p>Our professionally trained staff can solve any problem promptly and make sure your server runs uninterruptedly.</p>
                                    
                                    <h3 class="paragraph-title">Let\'s Make a Deal</h3>
                                    
                                    <p>If the existing offer does not meet your needs for some reason, please contact us and we\'ll find the best solution for you.</p>
                                '
                ]
            ],

            'tab_2' => [
                'sr-Latn' => [
                    'title' => 'Podrška',
                    'content' => '<p>Imamo stručno osobolje koje je sposobno da reši svaki problem u najkraćem mogućem roku kako biste  nesmetano radili.

                                    Pored standardne podrške nudimo i managed uslugu za zahtevnije korisnike sa specifičnim zahtevima.</p>',
                ],
                'en' => [
                    'title' => 'Additional services',
                    'content' => '<h3 class="paragraph-title">At any time, you can rent an additional bandwidth on a monthly basis or more hours of managed services server maintenance: </h3> <br><br>
                            
                            <p>Additional bandwidth:</p>
                            
                            <ul class="check-list">
                                <li>1TB : 10.00 €</li>
                                <li>2TB : 20.00 €</li>
                                <li>3TB : 30.00 €</li>
                                <li>5TB : 39.00 €</li>
                                <li>10TB : 69.00 €</li>
                                <li>20TB : 119.00 €</li>
                                <li>30TB : 149.00 €</li>
                            </ul>
                            <br>
                            <strong>SSL certificate</strong> – &euro;35 per month<br>
                            <strong>IP address</strong> - &euro;3 per month<br>
                            <strong>Cpanel</strong> - &euro;52 per month <br><br>
                            
                            <strong>Additional managed service hours:</strong> <br><br>
                            
                            • 54 EUR per hour <br>
                           '
                ]
            ],

            'tab_3' => [
                'sr-Latn' => [
                    'title' => 'cPanel',
                    'content' => '<p>Potpuna kontrola velikog broja sajtova uz pomoć cPanela, rešenja će koje koriste milioni klijenata poput Vas. CPanel je standard u hosting industriji namenjen hosting kompanijama kao i zakupcima namenskih servera koji žele da koriste sve pogodnosti koje cPanel pruža.</p>

                                    <p>Kreirajte neograničen broj korisnika na svom dedicated serveru.</p>
                                    '
                ],
                'en' => [
                    'title' => 'cPanel',
                    'content' => '
    
                            <ul class="check-list">
                                <li>Use all the benefits of the Chanel.</li>
                                <li>Known environment</li>
                                <li>Managing mail sertvices</li>
                                <li>Creating an unlimited number of hosting accounts</li>
                                <li>Free Comodo SSL for all hosting packages</li>
                            </ul>
                            
                            <h3 class="paragraph-title">Pricing:</h3>
                            
                            <ul class="check-list">
                                <li>CPanel WHM - 52 eur / month</li>
                            </ul>
                            
                            '
                ],
            ],

        ];

        return view('offers.common', compact(['offer', 'headTitle']));
    }

    public function getHousingOffer(Request $request)
    {
        $route = $request->route()->getName();
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Server Housing - Smeštaj servera ' : 'Cheap Server Housing Europe 1 Gbps';

        $product_line = ProductLineRepository::getByCode('server-housing');
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
        $offer->cartRoute = 'cart.server-housing';
        $offer->billingType = trans('main.' . $billingType);

        return view('offers.server-housing', compact(['offer', 'headTitle']));
    }

    public function getWindowsOffer(Request $request)
    {
        $route = $request->route()->getName();
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Windows Serveri u Srbiji - Licence 2008/2012/2019' : 'Windows Servers Europe 1 Gbps';

        $product_line = ProductLineRepository::getByCode('windows-servers');
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
        $offer->cartRoute = 'cart.windows-servers';
        $offer->billingType = trans('main.' . $billingType);

        $offer->tabs = [
            'tab_1' => [
                'en' => [
                    'title' => 'Info',
                    'content' => '<h3 class="paragraph-title">User Panels</h3><br>
                                In addition to customers’ access to the server, we have also provided an overview of the consumption of bandwidth and a user-friendly account management. <br><br>
                                
                                <h3 class="paragraph-title">Our Data Center</h3><br>
                                All equipment and servers are located in Ninet’s Data Center in Nis. We take good care of the equipment and operation of the data centre. <br>
                                All servers are connected to the port with the speed of 1 Gbps. <br><br>
                                
                                <h3 class="paragraph-title">Exceptional Support</h3><br>
                                Server installation and maintenance support is provided by ourlong-year experienced system administrators and thus we offer the best quality service to customers.'
                ]
            ],

            'tab_2' => [
                'sr-Latn' => [
                    'title' => 'Dodatne usluge',
                    'content' => '<h3 class="paragraph-title">U svakom trenutku možete zakupiti dodatni protok na mesečnom nivou ili dodatne sate managed usluge održavanja servera:</h3> <br><br>
                            
                            <ul class="check-list">
                                <li>1TB : 10.00 €</li>
                                <li>2TB : 20.00 €</li>
                                <li>3TB : 30.00 €</li>
                                <li>5TB : 39.00 €</li>
                                <li>10TB : 69.00 €</li>
                                <li>20TB : 119.00 €</li>
                                <li>30TB : 149.00 €</li>
                            </ul>
                            <br>
                            
                            SSL sertifikat – 35 eur<br>
                            IP adresa - 3 eur/ mes<br><br>
                            
                            Nakon osnovne instalacije servera i podrške sa naše strane neretko se dešava da je klijentu potrebna pomoć oko rešavanja specifičnih problema. <br>
                            U takvim situacijama predlažemo da zakupite jednu od 3 opcije koja podrazumeva administraciju servera, instaliranje specifičnih programa i sl. <br>
                            Cene managed usluge <br><br>
                            
                            • 3 sata - 40 eur/mesečno <br>
                            • 5 sati 50 eur/mesečno <br>
                            • 10 sati 80 eur/ mesečno',
                ],
                'en' => [
                    'title' => 'Additional services',
                    'content' => '<h3 class="paragraph-title">We have also provided some extra services, including:</h3> <br><br>
                            
                            <ul class="check-list">
                                <li>1TB : 10.00 €</li>
                                <li>2TB : 20.00 €</li>
                                <li>3TB : 30.00 €</li>
                                <li>5TB : 39.00 €</li>
                                <li>10TB : 69.00 €</li>
                                <li>20TB : 119.00 €</li>
                                <li>30TB : 149.00 €</li>
                            </ul>
                            <br>
                            <strong>SSL certificate</strong> – &euro;35 per month<br>
                            <strong>IP address</strong> - &euro;3 per month<br>
                            <strong>Cpanel</strong> - &euro;35 per month <br><br>
                            
                            Managed usluga (Održavanje servera)<br><br>
                            
                            At any time, you can rent an additional bandwidth on a monthly basis or more hours of managed services server maintenance: <br><br>
                            
                            <strong>Additional managed service hours:</strong> <br><br>
                            
                            • 3 hours 40 eur (expires 3 months from date of purchase) <br>
                            • 5 hours 50 eur (expires 5 months from date of purchase) <br>
                            • 10 hours 80 eur (expires 10 months from date of purchase)'
                ]
            ],

            'tab_3' => [
                'sr-Latn' => [
                    'title' => 'Dodatne licence',
                    'content' => '<h3 class="paragraph-title">Spisak Windows licenci koje izdajemo na zahtev klijenta:</h3>
    
                            <ul class="check-list">
                                <li>Windows Server 2012 Essentials</li>
                                <li>Windows Server 2012 Datacenter</li>
                                <li>Windows Server 2012 R2 Datacenter</li>
                                <li>Windows Server 2012 R2 Essentials</li>
                                <li>Windows Server 2012 R2 Standard</li>
                                <li>Windows Server 2012 Standard</li>
                                <li>Windows Server 2016 Datacenter</li>
                                <li>Windows Server 2016 Essentials</li>
                                <li>Windows Server 2016 Standard</li>
                                <li>Windows Server Datacenter 2008</li>
                                <li>Windows Server Datacenter 2008 R2</li>
                                <li>Windows Server Standard 2008 R2</li>
                                <li>Windows Server Standard 2008</li>
                                <li>Windows Remote Desktop Server licence SAL (per user)</li>
                                <li>Microsoft SQL server 2017 Enterprise</li>
                                <li>Microsoft SQL Server Standard Core</li>
                                <li>Microsoft SQL Server Web</li>
                            </ul>
                            <br><br>
                            
                            Ukoliko Vam je potrebna licenca koja nije na spisku obratite nam se putem tiketing servisa.'
                ],
                'en' => [
                    'title' => 'Additional licences',
                    'content' => '<h3 class="paragraph-title">Available licenses on demand:</h3> <br>
    
                            <ul class="check-list">
                                <li>Windows Server 2012 Essentials</li>
                                <li>Windows Server 2012 Datacenter</li>
                                <li>Windows Server 2012 R2 Datacenter</li>
                                <li>Windows Server 2012 R2 Essentials</li>
                                <li>Windows Server 2012 R2 Standard</li>
                                <li>Windows Server 2012 Standard</li>
                                <li>Windows Server 2016 Datacenter</li>
                                <li>Windows Server 2016 Essentials</li>
                                <li>Windows Server 2016 Standard</li>
                                <li>Windows Server Datacenter 2008</li>
                                <li>Windows Server Datacenter 2008 R2</li>
                                <li>Windows Server Standard 2008 R2</li>
                                <li>Windows Server Standard 2008</li>
                                <li>Windows Remote Desktop Server licence SAL (per user)</li>
                                <li>Microsoft SQL server 2017 Enterprise</li>
                                <li>Microsoft SQL Server Standard Core</li>
                                <li>Microsoft SQL Server Web</li>
                            </ul>'
                ],
            ],
            'tab_4' => [
                'sr-Latn' => [
                    'title' => 'Najčešća pitanja',
                    'content' => '<em>U koje svrhe mogu da koristim Windows server?</em> <br>
                        Najčešću primenu windows serveri našli su kod Microsoft proizvoda; Microsoft SQL,.NET aplikacije, ASP web aplikacije, Android mobilne aplikcije.<br><br>
                        <em>Koliko dugo se čeka na aktivaciju?</em><br>
                        Podaci za pristup serveru se šalju u roku od 24 h (radnim danom)  od trenutka uplate koja je poslata na e-mail naručioca.<br><br>
                        <em>Koja je razlika izmedju VPS i Dedicated servera?</em><br>
                        Glavna razlika u pogledu licenciranja izmedju windows dedicated servera i VPS windows hostinga je što je za dedicated server dovoljna jedna licenca dok se u slučaju VPS hostinga licenciranje vrši po threadu ili jezgru.<br><br>
                        <em>Da li postoji jeftinija opcija od trenutne?</em><br>
                        Mi smo već predefinisali pakete, ali ukoliko imate specifične zahteve javite nam se kako bi zajedno došli do rešenja<br><br>
                        <em>Da li mogu da pošaljem svoj server i da na njemu instalirate windows?</em><br>
                        U ovom slučaju je potrebno da odabere uslugu server housing i doplatite po licenci 25 eur<br><br>
                        <em>Koliko IP adresa mogu da dodam po serveru?</em><br>
                        Maksimalan broj IP adresa po serveru je 64.<br><br>
                        <em>Koje su cene ostalih window licenci?</em><br>
                        U ponudi imamo većinu windows licenci. Obratite nam se putem tiketing sistema',
                ],
                'en' => [
                    'title' => 'FAQ',
                    'content' => '<em>What purposes can I use a Windows Server for? </em><br>
                                The most common application of windows servers is found with Microsoft products; Microsoft SQL, .NET applications, ASP web applications, Android mobile-app. <br><br>
                                
                                <em>How long does it take to activate it? </em><br>
                                Credentials for the server access are normally sent to the client’s email address within 24 hours from the moment of payment. <br><br>
                                
                                <em>What is the difference between VPS and Dedicated Server? </em><br>
                                The main difference in terms of licensing between the windows dedicated server and VPS windows hosting is that the dedicated server takes one license as sufficient, while licensing for theVPS hosting is done by a thread or core. <br><br>
                                
                                <em>Is there a better offer than the current one? </em><br>
                                We have already redefined our packages; for specific requirements, please contact us via Ticketing System and we’ll jointly address your problem. <br><br>
                                
                                <em>How many IP addresses can I add per server? </em><br>
                                The maximum number of IP addresses per server is 64.'
                ]
            ]
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
}
