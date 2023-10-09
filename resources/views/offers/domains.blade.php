@extends('layouts.offer')

@section('page-title')
    {!! $offer->titleHtml !!}
@endsection

@section('page-description')
    {!! $offer->description !!}
@endsection

@section('styles')
    <style>
        .checkbox label {
            padding: 0 !important;
        }
        .checkbox label::before {
            top: 0 !important;
            border: 1px solid #878787 !important;
        }
        .checkbox label::after {
            top: 0 !important;
        }
    </style>
@endsection

@section('product-content')

    <section class="find-domain type2">
        <div class="container">
            <div class="search-form-block">
                <div class="row">
                    <div class="col-lg-4 col-xl-3">
                        <div class="find-domain-text">
                            <h3 class="text-uppercase">{{ __('main.search_domain') }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-9">
                        <form action="javascript:void(0)" id="domain-search-form">
                            <div class="search-holder">
                                <input class="js-find-domain" type="text" id="domain-search-name" placeholder="{{ __('main.insert_domain_name') }}" value="{{ old('domain_sld') }}">
                                <button type="submit"><span class="fa fa-search"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <form action="{{ route('cart.add-domains') }}" method="post">
                @csrf
                <div class="search-results-block js-domain-search-block">
                    <div class="search-results-holder js-domain-results-holder">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-4 col-xl-8 offset-xl-3">
                                <div class="outer-wrapper">
                                    <div class="inner-wrapper scroll-holder domains-scroller">
                                        <table id="domains-list">
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<div class="row">--}}
                {{--<div class="col-xs-12">--}}
                {{--<div id="domain_price_total" class="text-bolder">--}}
                {{--<span id="price_currency" class="pull-right">{!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</span>--}}
                {{--<span id="price_amount" class="pull-right"></span>--}}
                {{--<div class="clearfix"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}

                @if(count($errors))
                    <div class="alert alert-danger margin-t domain-errors">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="center">
                    <button type="submit" class="btn-t1 margin-t" id="add_domains_button" style="display: none;">{{ __('main.add_domains_to_cart') }}<span class="fa fa-cart-arrow-down"></span></button>
{{--                        <br> {{ App::getLocale() === 'sr-Latn' ? 'Samo za postojeće korisnike' : 'Only for existing customers' }}<span class="fa fa-cart-arrow-down" style="height: 66px"></span></button>--}}
                </div>
{{--                <div class="center">--}}
{{--                    <a href="https://webglobe.rs/"  class="btn-t1 margin-t" id="webglobe-link" style="display: none; margin-right: 48px">{{ App::getLocale() === 'sr-Latn' ? 'Želite da postanete korisnik?' : 'Want to become user?' }}</a>--}}
{{--                </div>--}}
            </form>

        </div>
    </section>

    <section class="why-ninet-domains">
        <div class="container">

            <div class="section-title-t2">
                <h1><span class="three-lines left"></span>{{ App::getLocale() === 'sr-Latn' ? 'ZAŠTO WEBGLOBE DOMENI?' : 'WHY WEBGLOBE DOMAINS?' }}<span class="three-lines right"></span></h1>
            </div>

            <div class="row why-ninet-list">
                <div class="col-md-6">
                    <div class="why-ninet-item">
                        <img src="{{ url('assets/images/why_ninet_1.png') }}" alt={{App::getLocale() === 'sr-Latn' ? 'Brza-registracija' :'Quick-Registration'}}>
                        <h3>{{ App::getLocale() === 'sr-Latn' ? 'Brza registracija' : 'Quick Registration' }}</h3>
                        <p>{{ App::getLocale() === 'sr-Latn' ? 'Već nakon provere domena u mogućnosti ste da isti ukoliko je slobodan registrujete na svoje ime kao fizičko lice ili na ime firme, ukoliko ste pravno lice.' : 'Right after checking the domain name, if available you can register it as a natural person or legal entity.' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="why-ninet-item">
                        <img src="{{ url('assets/images/why_ninet_2.png') }}" alt="{{App::getLocale() === 'sr-Latn' ? 'Zaštita privatnosti' : 'Privacy Policy'}}">
                        <h3>{{ App::getLocale() === 'sr-Latn' ? 'Zaštita privatnosti' : 'Privacy Policy' }}</h3>
                        <p>{{ App::getLocale() === 'sr-Latn' ? 'Klijentima kojima je bitna zaštita privatnosti t.j ne žele da bilo ko zna da su oni vlasnici internet domena, nudimo rešenje u vidu sakrivanja podataka preko whois servisa' : 'We offer solutions to the clients who care about the privacy protection, i.e. do not want anyone to know they are owners of internet domains, in the form of hiding the information through whois service.' }}.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="why-ninet-item">
                        <img src="{{ url('assets/images/why_ninet_3.png') }}"  alt={{App::getLocale() === 'sr-Latn' ? 'Plaćanje' : 'Payment'}}>
                        <h3>{{ App::getLocale() === 'sr-Latn' ? 'Plaćanje' : 'Payment' }}</h3>
                        <p>{{ App::getLocale() === 'sr-Latn' ? 'Pored dinarskog predračuna još brža opcija je plaćanje kreditnom karticom preko 2CheckOut sistema. Sve klijente obaveštavamo 30, 10 i 7 dana pre isteka domena.' : 'In addition to the dinar pro-form invoice, even faster way is to pay by credit card through the 2checkout system. We inform the clients 30 and 7 days before the domain expiry.' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="why-ninet-item">
                        <img src="{{ url('assets/images/why_ninet_4.png') }}" alt="{{App::getLocale() === 'sr-Latn' ? 'Pomoć i podrška' : 'Help and Support'}}">
                        <h3>{{ App::getLocale() === 'sr-Latn' ? 'Pomoć i podrška' : 'Help and Support' }}</h3>
                        <p>{{ App::getLocale() === 'sr-Latn' ? 'Imamo razumevanja i za one klijente koji do sada nisu imali iskustva sa internet servisima. Proces registracije domena je lak i jednostavan ali je uz našu podršku još lakši. Slobodno nam se obratite, preko emaila, tiketing sistema ili telefonom i nedoumice rešavamo zajedno.' : 'We have understanding for those clients who have no previous experience with internet services. The process of domain registration is easy and simple, or simpler with our support. Please contact us via email, phone or ticketing system and we will together resolve any concern.' }} </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="why-ninet-item">
                        <img src="{{ url('assets/images/why_ninet_5.png') }}" alt="{{App::getLocale() === 'sr-Latn' ? 'Jeftiniji domen' : 'Cheaper domain'}}"/>
                        <h3>{{ App::getLocale() === 'sr-Latn' ? 'Želite jeftinije domene svake godine?' : 'Do you want cheaper domain every year?' }}</h3>
                        <p>{{ App::getLocale() === 'sr-Latn' ? 'Pridružite se “Hosting Pilot” projektu i obezbedite sebi popuste na sve domene i to svake godine! Za sve dodatne informacije nas kontaktirajte.' : 'Sign up for “Hosting Pilot” ongoing project and make sure you have a discount on domains every year. For additional information, you can get in touch with our customer support service.' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="why-ninet-item">
                        <img src="{{ url('assets/images/why_ninet_6.png') }}" alt="{{App::getLocale() === 'sr-Latn' ? 'Uslovi registracije' : 'Terms of registration'}}"/>
                        <h3>{{ App::getLocale() === 'sr-Latn' ? 'Uslovi registracije' : 'Terms of registration' }}</h3>
                        <p>{{ App::getLocale() === 'sr-Latn' ? 'Ovde možete saznati više o' : 'Here you can find out more about' }} <a href="{{ App::getLocale() === 'sr-Latn' ? route('domains.opsti-uslovi-registracije-domena') : route('domains.general-terms-domain-registration') }}" target="_blank">{{ App::getLocale() === 'sr-Latn' ? 'opštim uslovima o registraciji naziva .RS domena' : ' the general terms of registering the .RS domain name' }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="domain-faq">
        <div class="container">
            <div class="faq-blocks">
                <div class="row faq-list">
                    <div class="col-lg-6">
                        <div class="faq-item">
                            <h3>{{ App::getLocale() === 'sr-Latn' ? 'Koji domen mogu da registrujem?' : 'What domain can I register?' }}</h3>
                            <p>{{ App::getLocale() === 'sr-Latn' ? 'Vaša je odluka koji domen kupujete.' : 'It is up to you which domain you would like to buy.' }}</p>
                        </div>
                        <div class="faq-item">
                            <h3>{{ App::getLocale() === 'sr-Latn' ? 'Kada moj sajt može biti dostupan korisnicima na internetu?' : 'When can my website be available to users on the Internet?' }}</h3>
                            <p>{{ App::getLocale() === 'sr-Latn' ? 'Ukoliko je sajt već uradjen i postavljen na hosting onda bi u roku od 24 h trebalo da bude dostupan svim online korisnicima.' : 'If the website has already been created and hosted, it should be available to all users within 24 hours.' }}</p>
                        </div>
                        <div class="faq-item">
                            <h3>{{ App::getLocale() === 'sr-Latn' ? 'Već imam registrovan domen i želeo bih izvršim transfer kod vas?' : 'I already have a registered domain and I would like to make a transfer to you now?' }}</h3>
                            <p>{{ App::getLocale() === 'sr-Latn' ? 'Proces prebacivanja domena je lak i jednostavan. Naša korisnička podrška poslaće Vam detaljna uputstva za prebacivanje .com , .rs ili bilo kog drugog domena.' : 'The domain transfer process is easy and simple. Our customer support will send you detailed instructions for transferring .com, .rs or any other domain.' }}</p>
                        </div>

                        <div class="faq-item">
                            <h3>{{ App::getLocale() === 'sr-Latn' ? 'Da li se registracija .rs domena može obaviti iz inostranstva ?' : 'Can registration of .rs domains be done from abroad?' }}</h3>
                            <p>{{ App::getLocale() === 'sr-Latn' ? 'Da,ali je za postupak provere i kupovine domena predvidjena engleska verzija sajta.' : 'Yes, however the English version of the website will prevail for checking and purchasing the domain.' }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="faq-item">
                            <h3>{{ App::getLocale() === 'sr-Latn' ? 'Kako povezati domen I hosting?' : 'How can I link domain and hosting?' }}</h3>
                            <p>{{ App::getLocale() === 'sr-Latn' ? 'Odmah nakon zakupa domena i dobijanja name servera šaljemo Vam podatke na email adresu i uputstvima za korišćenje. Ukoliko se domen nalazi u vlasništvu drugog provajdera potrebno je preusmeriti DNS servere ka nama.' : 'Immediately after the domain name is purchased and the nameserver delivered, we will send you the information to your email address and instructions for use. If the domain is owned by another service provider, you need to redirect DNS servers to us.' }}</p>
                        </div>
                        <div class="faq-item">
                            <h3>{{ App::getLocale() === 'sr-Latn' ? 'Još uvek imam pitanja...' : 'I still have questions...' }}</h3>
                            <p>{{ App::getLocale() === 'sr-Latn' ? 'Za sva dodatna pitanja obratite se našoj tehničkoj podršci kako bi problem rešili u najkraćem roku preko tiketing sistema ili na broj 018/3409888' : 'For any additional questions, please contact our technical support service to resolve the problem as shortest notice, through the ticketing system or at number 018/41-55-055' }}</p>
                        </div>
                        <div class="faq-item">
                            <h3>{{ App::getLocale() === 'sr-Latn' ? 'Koji su Webglobe DNS-ovi?' : 'What are the Webglobe DNSs?' }}</h3>
                            <p>{{ App::getLocale() === 'sr-Latn' ? 'Da bi preusmerili domen na Webglobe web hosting nalog potrebno je da upišete nameservere i to na sledeći način:' : 'In order to redirect the domain to the Webglobe web hosting account, you need to enter the nameservers in the following way:' }}</p>
                            <ul class="check-list">
                                <li><span>DNS</span> ns1.hostingweb.rs</li>
                                <li><span>{{ App::getLocale() === 'sr-Latn' ? 'IP adresa' : 'IP address' }}</span> 185.96.210.11</li>
                                <li><span>DNS</span> ns2.hostingweb.rs</li>
                                <li><span>{{ App::getLocale() === 'sr-Latn' ? 'IP adresa' : 'IP address' }}</span> 176.104.106.107</li>
                                <li><span>DNS</span> ns3.hostingweb.rs</li>
                                <li><span>{{ App::getLocale() === 'sr-Latn' ? 'IP adresa' : 'IP address' }}</span> 176.104.107.223</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="blockMessage" style="display:none;">
        <h4>{{ __('main.request_processing') }}</h4> <br>
        <span class="fa fa-spinner fa-spin fa-3x"></span>
    </div>

@endsection

@section('scripts')
    <script>
        var _check_domain_compatibility = '{{ route('domains.check-compatibility') }}';
    </script>
    <script src="{{ url('/assets/no_bower_components/jquery.blockUI.js') }}"></script>
    @include('offers.partials.domain-offer-scripts')
    <script src="{{ url('js/offers/domains.js') }}"></script>
@endsection