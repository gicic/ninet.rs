@extends('layouts.page-dc')

@section('page-content')

    <section class="simple-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="text-style">
                        <p>{{App::getLocale() === 'sr-Latn' ? 'Dragi klijenti,' : 'Dear Clients,'}}</p>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ? 'Ovim putem vas obaveštavamo da će doći do povećanja cena za gTLD domene.' : 'We’re hereby notifying you that there\'s an upcoming increase in prices for gTLD domains.'}}
                        </p>

                        <p>{{App::getLocale() === 'sr-Latn' ? 'Promena u cenovniku će se desiti zbog fluktuiranja vrednosti valuta (naročito USD i EUR pariteta).' :'The change in pricing will take place due to the fluctuating currency exchange rates (specifically USD and EUR parity).'}}</p><p>
                        <p>{{App::getLocale() === 'sr-Latn' ?' Pod novim ugovorom između institucija koje koordinišu domenima, cena registracija, transfera i obnova domena (posebno za .COM) će se širom sveta povećavati u nadolazećim godinama. Verisign, globalni provajder domena i internet infrastrukture, najavio je da će se cena .COM domena povećavati za 7% godišnje sve do 2029. ':'Under new agreements between entities responsible for coordinating domain names, the price of registrations, transfers, and renewals (especially for .COM) worldwide will incrementally increase in the upcoming years. Verisign, a global provider of domain name registry services and internet infrastructure, has announced that the price for .COM will increase by 7% yearly until 2029. '}}</p>

                        <p>{{App::getLocale() === 'sr-Latn' ? 'Webglobe se morao prilagoditi trenutnoj situaciji i adekvatno povećati cene svojih usluga, u odnosu na vrednost valuta i inflacije. Razumemo značaj ovih promena za sve naše klijente i znamo koliko će ova povećanja uticati na različite dimenzije cyber biznisa. ' :'Webglobe could only adapt to the current situation and make a necessary increment to the current pricing, which accommodates exchange and inflation rates increase only.'}}<br></p>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ? 'Promene u cenovniku će stupiti na snagu od 1. septembra 2022. godine.':'The changes in the pricing will start to apply from September 1st, 2022.'}}
                        </p>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ? 'Posvećeni smo pružanju kvalitetnih usluga i nadamo se daljem uspešnom poslovanju sa vama.':'We are committed to providing the best quality services and we hope to continue to do business with you.'}}
                        </p>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ? 'Kao i uvek, na raspolaganju smo vam i pozivamo vas da nas kontaktirate na':'As always, we are at your disposal, so please feel free to contact us at'}} <span class="text-primary"><a href="mailto:info@webglobe.rs">info@webglobe.rs</a></span>
                            {{App::getLocale() === 'sr-Latn' ? 'sa bilo kakvim pitanjima koja imate za nas.':'for any queries.'}}
                        </p>
                    </div>
                </div>
            </div>
            <table style="width: 50%">
                <tr>
                    <td><strong>{{App::getLocale() === 'sr-Latn' ? 'Ekstenzija':'Extension.'}}</strong></td>
                    <td><strong>{{App::getLocale() === 'sr-Latn' ? 'Cena-god':'Price-year'}}</strong></td>
                </tr>
                <tr>
                    <td>{{'.com'}}</td>
                    <td>{{App::getLocale() === 'sr-Latn' ? '1560 RSD':'13.5 €'}}</td>
                </tr>
                <tr>
                    <td>{{'.net'}}</td>
                    <td>{{App::getLocale() === 'sr-Latn' ? '1740 RSD':'14.8 €'}}</td>
                </tr>
                <tr>
                    <td>{{'.org'}}</td>
                    <td>{{App::getLocale() === 'sr-Latn' ? '1800 RSD':'15.5 €'}}</td>
                </tr>
                <tr>
                    <td>{{'.info'}}</td>
                    <td>{{App::getLocale() === 'sr-Latn' ? '2760 RSD':'25.5 €'}}</td>
                </tr>
                <tr>
                    <td>{{'.biz'}}</td>
                    <td>{{App::getLocale() === 'sr-Latn' ? '2460 RSD':'21 €'}}</td>
                </tr>
            </table>
            <div class="text-style">
                <p>{{App::getLocale() === 'sr-Latn' ? '*uključen PDV':'TAX Included'}}</p>
            </div>
        </div>
    </section>
@endsection
<style>
    table, th, td {
        border:1px solid black;
        text-align: center;
        margin-top: 20px;
        height: 35px;
    }
</style>
