@extends('layouts.page')

@section('page-title')
    {{ __('main.privacy_policy') }}
@endsection

@section('page-content')

    <section class="simple-page">
        <div class="container">
            <div class="text-style">
                <h2>{{ __('privacy-terms.privacy_h1') }}</h2>
                <p>{{ __('privacy-terms.privacy_h1p1') }}</p>
                <p>{{ __('privacy-terms.privacy_h1p2') }}</p>
                <h2>{{ __('privacy-terms.privacy_h2') }}</h2>
                <p>{{ __('privacy-terms.privacy_h2p1') }}</p>
                <p>{{ __('privacy-terms.privacy_h2p2') }}<a href="https://www2.ninet.rs/" target="_blank"><span class="text-primary"> www.ninet.rs.</span></a></p>
                <p>
                    {{ __('privacy-terms.privacy_h2p3') }}<br>
                    {{ __('privacy-terms.privacy_h2p4') }}<br>
                    {{ __('privacy-terms.privacy_h2p5') }}<br>
                    {{ __('privacy-terms.privacy_h2p6') }}6<br>
                    {{ __('privacy-terms.privacy_h2p7') }}
                </p>
                <h2>{{ __('privacy-terms.privacy_h3') }}</h2>
                <p>{{ __('privacy-terms.privacy_h3p1') }}</p>
                <p>{{ __('privacy-terms.privacy_h3p2') }}</p>
                <p>{{ __('privacy-terms.privacy_h3p3') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h3li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3li3') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3li4') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3li5') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3li6') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3li7') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h3p4') }}</p>
                <p>{{ __('privacy-terms.privacy_h3p5') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h3ul2li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3ul2li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3ul2li3') }}</li>
                    <li>{{ __('privacy-terms.privacy_h3ul2li4') }} <a href="https://www2.ninet.rs/" target="_blank"><span class="text-primary"> www.ninet.rs.</span></a></li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h3p6') }}</p>
                <p>{{ __('privacy-terms.privacy_h3p7') }}</p>
                <p>{{ __('privacy-terms.privacy_h3p8') }}</p>
                <p>{{ __('privacy-terms.privacy_h3p9') }}</p>
                <p>{{ __('privacy-terms.privacy_h3p10') }}</p>
                <p>{{ __('privacy-terms.privacy_h3p11') }}</p>

                <h2>{{ __('privacy-terms.privacy_h4') }}</h2>
                <p>{{ __('privacy-terms.privacy_h4p1') }}</p>
                <p>{{ __('privacy-terms.privacy_h4p2') }}</p>
            <ul>
                <li>{{ __('privacy-terms.privacy_h4ul1li1') }}</li>
                <li>{{ __('privacy-terms.privacy_h4ul1li2') }}</li>
                <li>{{ __('privacy-terms.privacy_h4ul1li3') }}</li>
                <li>{{ __('privacy-terms.privacy_h4ul1li4') }}</li>
            </ul>
                @if(App::getLocale() === 'sr-Latn')
                    <p>Internet pretraživači „Browsers“ omogućavaju kontrolu i upravljanje „kolačićima“. U  zavisnosti  od  toga koji pretraživač koristite, korisna uputstva možete naći na zvaničnim stranicama pretraživača, kao što su <a href="https://support.mozilla.org/en-US/kb/cookies-information-websites-store-on-your-computer?redirectlocale=en-US&redirectslug=Cookies" target="_blank"><span class="text-primary">Mozilla Firefox</span> </a>, <a href="https://support.microsoft.com/en-us/topic/delete-and-manage-cookies-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank"><span class="text-primary">Internet Explorer</span></a>, <a href="https://support.google.com/chrome/answer/95647?hl=en" target="_blank"><span class="text-primary">Google Chrome</span></a>, <a href="https://support.apple.com/en-us/HT201265" target="_blank"><span class="text-primary">Safari</span></a>. Dodatne informacije o „kolačićima“ možete naći na AboutCookies.org</p>
                    <p>Ninet Company d.o.okoristi uslugu treće strane, <a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gajs" target="_blank"><span class="text-primary">Google analitiku</span></a>, za sakupljanje standardnih informacija o posetama portalima i detalje o ponašanju posetilaca. Svrha obrade podataka ima za cilj praćenje posećenosti, u smislu broja posetilaca različitih delova sajta.  Obrada  informacija  ne  identifikuje  nikoga. Google nema saglasnost da obrađuje podatke na način koji bi otkrio identitet lica koja posećuju  web stranicu Ninet Company d.o.o.</p>
                @else
                    <p>The Internet “browsers” enable  control  and  management  of  "cookies".  Depending  on the browser  used,  you  can always find  useful  instructions  on  the  official websites of  the  browsers such  as <a href="https://support.mozilla.org/en-US/kb/cookies-information-websites-store-on-your-computer?redirectlocale=en-US&redirectslug=Cookies" target="_blank"><span class="text-primary">Mozilla Firefox</span> </a>, <a href="https://support.microsoft.com/en-us/topic/delete-and-manage-cookies-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank"><span class="text-primary">Internet Explorer</span></a>, <a href="https://support.google.com/chrome/answer/95647?hl=en" target="_blank"><span class="text-primary">Google Chrome</span></a>, <a href="https://support.apple.com/en-us/HT201265" target="_blank"><span class="text-primary">Safari</span></a>. Additional information about "cookies" can be found at AboutCookies.org.</p>
                    <p>Ninet Company Ltd. uses a third-party service, <a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gajs" target="_blank"><span class="text-primary">Google Analytics</span></a>, to collect standard information about portal visits and details about visitor behavior. The purpose of data processing is to track traffic, in terms of number of visitorsof various parts of the website.Data processing does not identify. Google does not have consent to process data in a way that would reveal the identity of persons visiting the website of Ninet Company Ltd.</p>
                @endif
                <h2>{{ __('privacy-terms.privacy_h5') }}</h2>
                <p>{{ __('privacy-terms.privacy_h5p1') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h5ul1li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h5ul1li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h5ul1li3') }}</li>
                    <li>{{ __('privacy-terms.privacy_h5ul1li4') }}</li>
                    <li>{{ __('privacy-terms.privacy_h5ul1li5') }}</li>
                    <li>{{ __('privacy-terms.privacy_h5ul1li6') }}</li>
                    <li>{{ __('privacy-terms.privacy_h5ul1li7') }}</li>
                    <li>{{ __('privacy-terms.privacy_h5ul1li8') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h5p2') }}</p>
                @if(App::getLocale() === 'sr-Latn')
                <p>{{ __('privacy-terms.privacy_h5p3') }} <a href="https://www2.ninet.rs/support-info" target="_blank"><span class="text-primary">{{ __('privacy-terms.privacy_h5p1.1') }}</span></a></p>
                @else
                    <p>{{ __('privacy-terms.privacy_h5p3') }} <a href="https://www2.ninet.rs/en/support-info" target="_blank"><span class="text-primary">{{ __('privacy-terms.privacy_h5p1.1') }}</span></a></p>
                @endif
                    <p>{{ __('privacy-terms.privacy_h5p4') }}</p>
                <ul>
                    @if(App::getLocale() === 'sr-Latn')
                        <li>{{ __('privacy-terms.privacy_h5ul2li1') }} <a href="https://www2.ninet.rs/support-info" target="_blank"><span class="text-primary">{{ __('privacy-terms.privacy_h5ul2li1.1') }}</span></a></li>
                    @else
                        <li>{{ __('privacy-terms.privacy_h5ul2li1') }} <a href="https://www2.ninet.rs/en/support-info" target="_blank"><span class="text-primary">{{ __('privacy-terms.privacy_h5ul2li1.1') }}</span></a></li>
                    @endif
                    <li>
                        {{ __('privacy-terms.privacy_h5ul2li2.1') }}<br>
                        {{ __('privacy-terms.privacy_h5ul2li2.2') }}<br>
                        {{ __('privacy-terms.privacy_h5ul2li2.3') }}
                    </li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h5p5') }}</p>
                <p>{{ __('privacy-terms.privacy_h5p6') }}</p>
                <p>{{ __('privacy-terms.privacy_h5p7') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h5ul3li1') }}</li>
                    @if(App::getLocale() === 'sr-Latn')
                        <li>{{ __('privacy-terms.privacy_h5ul3li2') }} <a href="https://www.poverenik.rs" target="_blank"><span class="text-primary">nadležnom organu;</span></a></li>
                    @else
                        <li>{{ __('privacy-terms.privacy_h5ul3li2') }} <a href="https://www.poverenik.rs" target="_blank"><span class="text-primary">competent authority;</span></a></li>
                    @endif
                    <li>{{ __('privacy-terms.privacy_h5ul3li3') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h5p8') }}</p>
                <p>
                    {{ __('privacy-terms.privacy_h5p9.1') }}<br>
                    {{ __('privacy-terms.privacy_h5p9.2') }}<br>
                    {{ __('privacy-terms.privacy_h5p9.3') }}<br>
                    {{ __('privacy-terms.privacy_h5p9.4') }}<br>
                    {{ __('privacy-terms.privacy_h5p9.5') }}<br>
                    <a href="mailto:zastitapodataka@ninet.rs" target="_blank"><span class="text-primary">zastitapodataka@ninet.rs</span></a>
                </p>
                <p>{{ __('privacy-terms.privacy_h5p10') }}</p>
                <h2>{{ __('privacy-terms.privacy_h6') }}</h2>
                <p>{{ __('privacy-terms.privacy_h6p1') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h6ul1li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h6ul1li2') }}</li>
                </ul>
                <h5>{{ __('privacy-terms.privacy_h7') }}</h5>
                <p>{{ __('privacy-terms.privacy_h7p1') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p2') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h7ul1li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul1li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul1li3') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul1li4') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul1li5') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul1li6') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul1li7') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h7p3') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h7ul2li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul2li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul2li3') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul2li4') }}</li>
                </ul>
                <p><u>{{ __('privacy-terms.privacy_h7p4') }}</u></p>
                <p>{{ __('privacy-terms.privacy_h7p5') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h7ul3li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul3li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul3li3') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul3li4') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul3li5') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul3li6') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul3li7') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h7p6') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h7ul4li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul4li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul4li3') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul4li4') }}</li>
                    <li>{{ __('privacy-terms.privacy_h7ul4li5') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h7p7') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p8') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p9') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p10') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p11') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p12') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p13') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p14') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p15') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p16') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p17') }}</p>

                <ul>
                    <li>{{ __('privacy-terms.privacy_h7ul5li1') }} <a href="mailto:zastitapodataka@ninet.rs" target="_blank"><span class="text-primary">zastitapodataka@ninet.rs</span></a></li>
                    <li>
                        {{ __('privacy-terms.privacy_h7ul5li2.1') }}<br>
                        {{ __('privacy-terms.privacy_h7ul5li2.2') }}<br>
                        {{ __('privacy-terms.privacy_h7ul5li2.3') }}
                    </li>
                    <li>{{ __('privacy-terms.privacy_h7ul5li3') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h7p18') }}</p>
                @if(App::getLocale() === 'sr-Latn')
                    <p>U cilju sprečavanja i otkrivanja visokotehnološkog kriminala mreža Ninet Company d.o.oa je pod stalnim monitoringom. U slučaju otkrivanja pokušaja sajber napada, Ninet Company d.o.o je u obavezi da o tome obavesti <a href="https://www.cert.rs/" target="_blank"><span class="text-primary"> Nacionalni CERT Republike Srbije</span></a>, kao i da dostavi sve potrebne podatke u skladu sa zakonom.</p>
                @else
                    <p>In order to prevent and detect high-tech crime, the network of Ninet Company Ltd.is under constant monitoring. In case of detection of an attempted cyber-attack, Ninet  Company Ltd. is obliged to  inform the <a href="https://www.cert.rs/" target="_blank"><span class="text-primary"> National CERT of the Republic of Serbia</span></a>, as well as to submit all necessary data in accordance with the law.</p>
                @endif
                <p>{{ __('privacy-terms.privacy_h7p20') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p21') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p22') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p23') }}</p>
                <p>{{ __('privacy-terms.privacy_h7p24') }}</p>

                <h5>{{ __('privacy-terms.privacy_h8') }}</h5>
                <p>{{ __('privacy-terms.privacy_h8p1') }}</p>
                <h5>{{ __('privacy-terms.privacy_h9') }}</h5>
                <p>{{ __('privacy-terms.privacy_h9p1') }}</p>
                <h5>{{ __('privacy-terms.privacy_h11') }}</h5>
                <p>{{ __('privacy-terms.privacy_h11p1') }}</p>
                <p>{{ __('privacy-terms.privacy_h11p2') }}</p>
                <p>{{ __('privacy-terms.privacy_h11p3') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h11ul1li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h11ul1li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h11ul1li3') }}</li>
                    <li>{{ __('privacy-terms.privacy_h11ul1li4') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h11p4') }}</p>
                <p>{{ __('privacy-terms.privacy_h11p5') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h11ul2li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h11ul2li2') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h11p6') }}</p>
                <h6>{{ __('privacy-terms.privacy_h12') }}</h6>
                <p>{{ __('privacy-terms.privacy_h12p1') }} <a href="https://www.facebook.com/ninet.nis" target="_blank"><span class="text-primary"> {{ __('privacy-terms.privacy_h12p4') }}</span></a>  <a href="https://twitter.com/NinetHosting" target="_blank"><span class="text-primary"> {{ __('privacy-terms.privacy_h12p5') }}</span></a> <a href="https://www.instagram.com/ninethosting1/" target="_blank"><span class="text-primary"> {{ __('privacy-terms.privacy_h12p6') }}</span></a><a href="https://www.linkedin.com/company/ninet-company" target="_blank"><span class="text-primary"> {{ __('privacy-terms.privacy_h12p7') }}</span></a></p>
                <p>{{ __('privacy-terms.privacy_h12p2') }}</p>
                <p>{{ __('privacy-terms.privacy_h12p3') }}</p>

                <h6>{{ __('privacy-terms.privacy_h13') }}</h6>
                <p>{{ __('privacy-terms.privacy_h13p1') }}</p>
                <p>{{ __('privacy-terms.privacy_h13p2') }}</p>
                <p>{{ __('privacy-terms.privacy_h13p3') }}</p>
                <ul>
                    <li>{{ __('privacy-terms.privacy_h13ul1li1') }}</li>
                    <li>{{ __('privacy-terms.privacy_h13ul1li2') }}</li>
                    <li>{{ __('privacy-terms.privacy_h13ul1li3') }}</li>
                </ul>
                <p>{{ __('privacy-terms.privacy_h13p4') }}</p>
                <h6>{{ __('privacy-terms.privacy_h14') }}</h6>
                <p>{{ __('privacy-terms.privacy_h14p1') }}</p><br>

                <h6>{{ __('privacy-terms.glossary') }}</h6>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term1') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term1_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term2') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term2_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term3') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term3_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term4') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term4_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term5') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term5_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term6') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term6_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term7') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term7_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term8') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term8_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term10') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term10_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term11') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term11_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term12') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term12_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term13') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term13_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term14') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term14_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term15') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term15_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term16') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term16_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term17') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term17_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term18') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term18_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term19') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term19_value') }}<hr></div>

                <div class="col-lg-2">{{ __('privacy-terms.glossary_term20') }}</div>
                <div class="col-lg-10">{{ __('privacy-terms.glossary_term20_value') }}<hr></div>
            </div>
        </div>
    </section>

@endsection