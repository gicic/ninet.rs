<?php

namespace App\Http\Controllers;

use App\CommonOffer;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Rules\DomainSld;
use App\Services\CoreAPI\Domains;
use App\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class DomainOfferController extends Controller
{
    public function getOffer(Request $request)
    {
        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Registracija domena - Kupovina .rs .com .org domena' : 'Interent Domain Registration';

        $offer = new CommonOffer('Domeni', $request->route()->getName());
        $offer->titleHtml = \App::getLocale() === 'sr-Latn' ? '<span class="c-yellow">Registracija</span> domena' : 'RS domains';
        $descriptionSr = 'Prvi koraci u kreiranju sajta su provera i registracija domena. Budite brži od Vaše konkurencije, registrujte internet domen i obezbedite mesto na webu.';
        $descriptionEn = 'The first steps in creating a website include checking and registering a domain name. Be faster than your competition, register your internet domain and secure your place on the Web.';
        $offer->description = \App::getLocale() === 'sr-Latn' ? $descriptionSr : $descriptionEn;

        $products = ProductRepository::getAllDomains();

        $offer->items = $products;
        $offer->cartRoute = 'cart.domain';

        $offer->tabs = [

            'tab_1' => [
                'en' => [
                    'title' => 'Why Webglobe domains?',
                       'content' => '
                    
                        <h3 class="paragraph-title">Help and Support</h3>
                        
                        <p>We have understanding for those clients who have no previous experience with internet services. The process of domain registration is easy and simple, or simpler with our support. Please contact us via email, phone or ticketing system and we\'ll together resolve any concern.</p>
                        
                        <h3 class="paragraph-title">Quick Registration</h3>
                        
                        <p>Right after checking the domain name, if available you can register it as a natural person or legal entity.</p>

                        <h3 class="paragraph-title">Payment</h3>
                        
                        <p>In addition to the dinar pro-form invoice, even faster way is to pay by credit card through the 2checkout system. We inform the clients 30 and 7 days before the domain expiry.</p>
                        
                        <h3 class="paragraph-title">Brand Packages</h3>
                        
                        <p>For our clients - legal entities and natural persons - we offer a discount if they decide to register 2 domains, provided both are available.</p>
                        
                        <h3 class="paragraph-title">Privacy Policy</h3>
                        
                        <p>We offer solutions to the clients who care about the privacy protection, i.e. do not want anyone to know they are owners of internet domains, in the form of hiding the information through whois service.</p>
                    
                    '
                ],
                'sr-Latn' => [
                    'title' => 'Zašto Webglobe domeni?',
                       'content' => '
                    
                        <h3 class="paragraph-title">Instant aktivacija i upravljanje</h3>
                        
                        <p>Odmah nakon plaćenog domena putem kreditne kartice dobijate pristup korisničkom panelu odakle upravljate DNS-ovima.</p>
                        
                        <h3 class="paragraph-title">Niske cene domena</h3>
                        
                        <p>Ubedljivo najniža cena .com domena u Srbiji. Nacionalni .rs domeni su vrlo često i besplatni u akcijama koje organizujemo u kontinuitetu. U slučaju da imate veći broj domena predlažemo da nam se obratite putem tiketing sistema kako bi Vam dali još veće popuste- na registraciju ali i na obnovu, tako da svaki put uštedite.</p>

                        <h3 class="paragraph-title">Transfer domena</h3>
                        
                        <p>Lako i bezbedno uradite besplatan transfer domena.</p>',

                ],
            ],

            'tab_2' => [
                'sr-Latn' => [
                    'title' => 'Često postavljana pitanja',
                    'content' => '
                        <strong><em>Koji domen mogu da registrujem?</em></strong> <br>
                        Vaša je odluka koji domen kupujete. <br><br>
                    
                        <strong><em>Kada moj sajt može biti dostupan korisnicima na internetu?</em></strong> <br>
                        Ukoliko je sajt već uradjen i postavljen na hosting onda bi u roku od 24 h trebalo da bude dostupan svim online korisnicima. <br><br>
                    
                        <strong><em>Već imam registrovan domen i želeo bih izvršim transfer kod vas?</em></strong> <br>
                        Proces prebacivanja domena je lak i jednostavan. Naša korisnička podrška poslaće Vam detaljna uputstva za prebacivanje .com , .rs ili bilo kog drugog domena. Za transfer .RS domena je potrebno da nam pošaljete autorizacioni kod <br><br>
                    
                        <strong><em>Da li se registracija .rs domena može obaviti iz inostranstva ?</em></strong> <br>
                        Da,ali je za postupak provere i kupovine domena predvidjena engleska verzija sajta. <br><br>
                    
                        <strong><em>Kako povezati domen I hosting?</em></strong> <br>
                        Odmah nakon zakupa domena i dobijanja imena servera  šaljemo Vam podatke i uputstva za korišćenje na email adresu. Ukoliko se domen nalazi u vlasništvu drugog provajdera potrebno je preusmeriti DNS servere ka nama.                    
                       <strong><em>Još uvek imam pitanja...</em></strong> <br>
                       Za sva dodatna pitanja obratite se našoj tehničkoj podršci kako bi problem rešili u najkraćem roku preko tiketing sistema ili na broj 018/3409888 <br><br>
                    
                       <strong><em>Da li mogu da registrujem domene koji nisu na listi?</em></strong> <br>
                       Pošaljite nam zahtev koji domen želite da registrujemo i potrudićemo se da Vam damo najbolju cenu, vrlo često manju nego kod velikih provajdera. <br><br>
                    
                       <strong><em>Koji su Webglobe DNS-ovi?</em></strong> <br>
                       Da biste preusmerili domen na Webglobe web hosting nalog potrebno je da upišete ime servera i to na sledeći način: <br><br>
                    
                       <ul class="check-list">
                          <li>DNS: ns1.hostingweb.rs</li>
                          <li>IP adresa: 185.96.210.11</li>
                          <li>DNS: ns2.hostingweb.rs</li>
                          <li>IP adresa: 176.104.106.107</li>
                          <li>DNS: ns3.hostingweb.rs</li>
                          <li>IP adresa: 176.104.107.223</li>
                       </ul>
                    '
                ],

                'en' => [
                    'title' => 'FAQ',
                      'content' => '
                       <strong><em>Can I transfer Serbian Domains to my account?</em></strong> <br>
                        Yes. Please contact our support for further asisstance and transfer process. <br><br>
                    
                       <strong><em>Can I change DNS servers ?</em></strong> <br>
                        Yes, right after domains registration you will receive e-mail with Information about your domains.<br><br>
                    
                       <strong><em>Are you Accredited Serbian registar of .RS domains?</em></strong> <br>
                       Yes we are Accredited registrar of all serbian domains<br><br>
                    
                       <strong><em>What is the maximum period of domain of domain registration?</em></strong> <br>
                       The Maximum period you can register serbian domain names is 10 years.<br><br>
                    
                       <strong><em>Do you have a list of premium domain names?</em></strong> <br>
                        Yes. We search for premium domains and send them trough our email newsletter for free.<br><br>
                    
                    
                        <h3 class="paragraph-title">Terms & Conditions</h3>
                        <a href="https://www.rnids.rs/en/documents/general-terms-and-conditions-registration-national-internet-domain-names-0">General Terms and Conditions</a><br><br>
                        <a href="https://www.rnids.rs/en/">RNIDS</a>
                    '
                ],
            ],

        ];

        return view('offers.domains', compact(['offer', 'headTitle']));
    }

    public function getDomainList(Request $request)
    {
        $domainsExt = ProductRepository::getAllDomains();
        $sld = strtolower($request->domainSld);

        $v = $this->validator(['sld' => $sld]);

        $domains = [];
        if($v->fails()) {
            $data['validatorErrors'] = $v->errors()->all();
        } else {
            foreach ($domainsExt as $domainExt) {
                $isAvailable = Domains::isAvailable( $sld, $domainExt->name);
                if($domainExt->name === '.in.rs' && Cart::hasCoRsDomain()) {
                    $domains[$domainExt->name]['available'] = false;
                    $domains[$domainExt->name]['errors'][] = __('main.domain_cart_has_org_rs');
                } else if($domainExt->name === '.co.rs' && Cart::hasInRsDomain()) {
                    $domains[$domainExt->name]['available'] = false;
                    $domains[$domainExt->name]['errors'][] = __('main.domain_cart_has_in_rs');
                } else if ((isset($isAvailable->isAvailable) && $isAvailable->isAvailable)) {
                    $domains[$domainExt->name]['available'] = true;
                } else {
                    $domains[$domainExt->name]['available'] = false;
                    $domains[$domainExt->name]['errors'][] = __('main.domain_is_not_available');
                }
                $domains[$domainExt->name]['id'] = $domainExt->id;
                $domains[$domainExt->name]['name'] = $sld . $domainExt->name;
                $domains[$domainExt->name]['tld'] = $domainExt->name;
                $domains[$domainExt->name]['price'] = $domainExt->getDomainPrice();
            }
        }

        $data['domains'] = $domains;
        $data['sld'] = $sld;

        return view('offers.partials.domain-item', compact('data'));
    }

    public function checkDomainCompatibility(Request $request)
    {
        $inRs = Product::where('code', 'inrs')->first();
        $coRs = Product::where('code', 'cors')->first();

        $domain = Product::find($request->productId);

        $disableDomains = [];
        if($domain->code === 'inrs' && !empty($coRs)) {
            $disableDomains[] = $coRs->id;
        }
        if($domain->code === 'cors' && !empty($inRs)) {
            $disableDomains[] = $inRs->id;
        }

        return response()->json(compact('disableDomains'));
    }

    public function validator($data)
    {
        $rules = ['sld' => [new DomainSld()]];

        return \Validator::make($data, $rules);
    }

    public function generalTermsDomainRegistrationPdf(Request $request)
    {
        $file = \Storage::disk('local')->get('general-terms-domain-registration.pdf');
        return response($file, 200)->header('Content-Type', 'application/pdf');
    }

    public function opstiUsloviRegistracijeDomenaPdf(Request $request)
    {
        $file = \Storage::disk('local')->get('opsti-uslovi-registracije-domena.pdf');
        return response($file, 200)->header('Content-Type', 'application/pdf');
    }
}
