<?php

namespace App\Http\Controllers;

use App\CommonOffer;
use App\Mail\InternetRequest;
use App\Models\Internet;
use App\Models\Proizvodi;
use App\Repositories\ProductLineRepository;
use App\Repositories\ProductRepository;
use App\Rules\MacAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InternetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $product = Proizvodi::findOrFail($id);

        return view('internet.create', compact(['product']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'g-recaptcha-response' => 'required|captcha',
            'first_name'           => 'required',
            'last_name'            => 'required',
            'address'              => 'required',
            'city'                 => 'required',
            'phone'                => 'required',
            'email'                => 'required|email',
            'terms_and_conditions' => 'required',
        ], [
            'first_name.required'           => 'Unesite Vaše ime',
            'last_name.required'            => 'Unesite Vaše prezime',
            'address.required'              => 'Unesite Vašu adresu',
            'city.required'                 => 'Unesite grad (mesto)',
            'phone.required'                => 'Unesite kontakt telefon',
            'email.required'                => 'Unesite email adresu',
            'email.email'                   => 'Unesite validnu email adresu',
            'terms_and_conditions.required' => 'Morate prihvatiti uslove korišćenja',
        ]);

        try {
            \DB::beginTransaction();

            $internet = new Internet();
            $internet->id_proizvod = $request->product_id;
            $internet->uredjaj = '';
            $internet->ime = $request->first_name;
            $internet->prezime = $request->last_name;
            $internet->kompanija = $request->has('company') ? 1 : 0;
            $internet->naziv_kompanije = $request->company ?? '';
            $internet->mail = $request->email;
            $internet->adresa_korisnika = $request->email;
            $internet->mesto = $request->city;
            $internet->telefon_1 = $request->phone;
            $internet->mobilni_1 = $request->mobile_phone ?? '';
            $internet->telefon_2 = '';
            $internet->mobilni_2 = '';
            $internet->fax = '';
            $internet->mac = '';
            $internet->ip = '';
            $internet->sektor_ip = '';
            $internet->ruter_mac = '';
            $internet->otvorio_korisnik = 1;
            $internet->vreme_zahtev = Carbon::now()->toDateTimeString();
            $internet->maticni_broj_kompanije = '';
            $internet->pib = '';
            $internet->adresa_montaze = '';
            $internet->postanski_broj = '';
            $internet->mesto_montaze = '';
            $internet->postanski_broj_montaze = '';
            $internet->wi = '';
            $internet->komentar = $request->comment ?? '';
            $internet->save();

            \Mail::to('support@ninet.rs')->send(new InternetRequest($internet, [
                'card_type' => $request->card_type ?? null,
                'mac_ap'    => $request->mac_ap ?? null,
                'mac_lan'   => $request->mac_lan ?? null,
                'mac_card'  => $request->mac_card ?? null,
                'ssid'      => $request->ssid ?? null,
                'ip'        => $request->ip(),
                'choice'    => $request->choice ?? null,
            ]));

            \DB::commit();

            return view('internet-request-info', compact('internet'));
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Internet request error', ['exception' => $e, 'request' => $request->all()]);
            dd($e);
            return redirect()->back()->with('flash-danger', 'Greška prilikom podnošenja zahteva.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function offerWireless(Request $request)
    {

        $title = __('main.wireless_internet');
        $description = \App::getLocale() === 'sr-Latn' ? 'Najbolji internet bez ugovorne obaveze.' : 'Jedini optički internet u Srbiji bez ugovorne obaveze';
        $products = Proizvodi::whereIn('id_proizvodi', [229, 230, 231, 232])->orderBy('price', 'asc')->get();
        $colspan = [
            'span'   => 3,
            'offset' => 0
        ];
        $offer = new CommonOffer();
        $offer->category = 'internet';
        $offer->colspan = $colspan;
        $offer->items = $products;
        $offer->titleHtml = '<span class="c-yellow">' . $title . '</span>';
        $offer->title = $title;
        $offer->description = $description;
        $offer->route = $request->route()->getName();

        $offer->tabs = [
            'tab_1' => [
                'sr-Latn' => [
                    'title' => 'Bez ugovorne obaveze',
                    'content' => '
                        <p>Jedini u Srbiji nudimo naš internet bez ugovorne obaveze. Prva  3 meseca plaćanje unapred, a nakon toga mozete preći na mesečne pretplate.</p>
                    '
                ],
            ],

            'tab_2' => [
                'sr-Latn' => [
                    'title' => 'Pokrivenost',
                    'content' => '
                        <p>Pokrivamo veći deo Južne Srbije.</p>
                        <p>Otkako smo 2003. godine krenuli sa radom broj zadovoljnih korisnika neprekidno raste. Jugoistocna Srbija: Niš, Doljevac, Aleksinac, Leskovac, Lebane, Vlasotince... Takođe naš Internet je prisutan i u okolnim manjim mestima.</p>
                    ',
                ],
            ],

            'tab_3' => [
                'sr-Latn' => [
                    'title' => 'Klijenti',
                    'content' => '
                        <p>U proteklih 15 godina svoje poslovanje proširili smo na veći deo jugoistočne Srbije. Preko 5000 je do sada koristilo naše wireless usluge.</p>
                    '
                ],
            ],

            'tab_4' => [
                'sr-Latn' => [
                    'title' => 'Odlična podrška',
                    'content' => '
                        <p>Shvatamo potrebu klijenata da neprestano budu online. Naš stručno obučeni kadar ne ostavlja nerešen problem bilo koje vrste. Eventualne poteškoće u radu i nedoumice rešavamo na licu mesta. U roku od 24 časa, nakon provere optičke vidljivosti instaliraćemo wireless opremu vrhunskog kvaliteta.</p>
                        <p>Dežurnu tehničku podršku mozete dobiti na broj <strong>+381 65 941-00-00</strong> (Radnim danima: 08:00 - 20:00, subotom: 10:00 - 14:00)</p>
                    '
                ],
            ],
        ];

        return view('internet.offer', compact('offer'));
    }

    public function offerFiber(Request $request)
    {
        $title = __('main.fiber_internet');
        $title_1 = __('main.make_a_smart_choice');
        $description =  '';
        $products = Proizvodi::whereIn('id_proizvodi', [367, 368, 369])->orderBy('price', 'asc')->get();
        $colspan = [
            'span'   => 4,
            'offset' => 0
        ];
        $offer = new CommonOffer();
        $offer->category = 'internet';
        $offer->colspan = $colspan;
        $offer->items = $products;
        $offer->title = $title;
        $offer->titleHtml = '<span class="c-yellow">' . $title . '<br> ' . $title_1 . '</span>';
        $offer->description = $description;
        $offer->route = $request->route()->getName();

        $offer->tabs = [
            'tab_1' => [
                'sr-Latn' => [
                    'title' => 'Posebne pogodnosti Fiber interneta',
                    'content' => '<h3 class="paragraph-title"><span class="fa fa-bar-chart"></span>Odlične performanse</h3>
                            
                            <p>Optički (Fiber) internet sa sobom nosi mnogo veći protok i mnogo veću pouzdnost rada. Naši paketi nisu vezani za ugovornu obavezu, tako sa ste slobodni da birate hoćete li nastaviti da budete naš korisnik ili ne. Ovu mogućnost Vam nudimo jer smo sigurni u naš kvalitet i znamo da će te pre svaga zbog kvaliteta i pouzdanosti i ostati naš korisnik. </p>'
                ],
            ],

            'tab_2' => [
                'sr-Latn' => [
                    'title' => 'ZAŠTO NINET OPTIČKI INTERNET?',
                    'content' => '
                    
                        <p>Pokrivamo značajan deo Niša</p>
                        
                        <p>Uz ove pakete moguće je pretplatiti se na korišćenje statičke javne ip adrese uz uvećanje računa od samo 590 din. mesečno sa PDV-om. </p>
                        
                        <p>Dodatne povoljnosti za pakete uz ugovor na 12 i 24 meseci: Korisnik uz ugovor na 12 i 24 meseci dobija na korišćenje wireless ruter.</p>
                        
                        <!--<table class="table">
                            <thead>
                            <tr>
                                <th>Prva uplata (meseci)</th>
                                <th>Oprema na revers</th>
                                <th>Dodatni besplatni meseci</th>
                                <th>Wireless ruter na revers</th>
                                <th>Cena</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>3</td>
                                    <td>da</td>
                                    <td>ne</td>
                                    <td>/</td>
                                    <td>4500 RSD</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>da</td>
                                    <td>1</td>
                                    <td>ne</td>
                                    <td>7500 RSD</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>da</td>
                                    <td>2</td>
                                    <td>ne</td>
                                    <td>15000 RSD</td>
                                </tr>
                            </tbody>
                        </table>-->
                    ',
                ],
            ],

            'tab_3' => [
                'sr-Latn' => [
                    'title' => 'Brojevi govore umesto nas',
                    'content' => '
                   
                        <p>Preko 5000 zadovoljnih klijenata deo je velike NiNet porodice. Postojimo više od 10 godina. </p>
                        <p>Pokrivamo preko 50% jugoistočne Srbije.</p>
                    '
                ],
            ],

            'tab_4' => [
                'sr-Latn' => [
                    'title' => 'Vrhunska oprema',
                    'content' => '
                   
                        <p>Pratimo trendove iz oblasti optičkog interneta i zbog toga svake godine nudimo klijentima novu najmoderniju opremu.</p>
                    '
                ],
            ],
        ];

        return view('internet.offer', compact('offer'));
    }

    public function terms(Request $request)
    {
        $file = \Storage::disk('local')->get('opsti uslovi.pdf');

        return response($file, 200)->header('Content-Type', 'application/pdf');
    }

    public function personalityDataPdf(Request $request)
    {
        $file = \Storage::disk('local')->get('obrada-podataka-o-licnosti.pdf');
        return response($file, 200)->header('Content-Type', 'application/pdf');
    }

    public function objectionResolvePdf(Request $request)
    {
        $file = \Storage::disk('local')->get('resavanje-prigovora.pdf');
        return response($file, 200)->header('Content-Type', 'application/pdf');
    }
}
