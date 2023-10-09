@extends('layouts.page')

@section('page-title')
    {{ __('main.welcome') }}
@endsection

@section('page-description')
  {{App::getLocale() === 'sr-Latn' ? 'Ninet podrška' : 'Ninet support'}}
@endsection

@section('page-content')

    <section class="simple-page" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="text-style">
                        <h2>
                             <span class="c-yellow"> {{App::getLocale() === 'sr-Latn' ? 'Internet podrška' : 'Internet support'}}</span>
                        </h2>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ? 'Ukoliko imate pitanja u vezi sa internetom, želite da postanete NiNet internet korisnik, da prijavite problem, proverite Vaš internet nalog - kontaktirajte našu INTERNET podršku slanjem email-a ili telefonskim putem.':'If you have questions about the Internet, you want to become a NiNet Internet user, report a problem, check your Internet account - contact our INTERNET support by sending an email or phone.'}}
                        </p>
                        <h3>
                            {{App::getLocale() === 'sr-Latn' ?' Radno vreme Internet podrške:':'Internet support working hours:'}}
                        </h3>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ?' Ponedeljak-Petak: 8-20h':'Monday-Friday: 8-20h'}}<br>
                            {{App::getLocale() === 'sr-Latn' ?' Subota: 10-14h':'Saturday: 10-14h'}}<br>
                            {{App::getLocale() === 'sr-Latn' ?' Nedelja: Neradni dan':'Sunday: Non-working day'}}
                        </p>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ?' E-mail kontakt: support@ninet.rs':'E-mail contact: support@ninet.rs'}}<br>
                            {{App::getLocale() === 'sr-Latn' ?' Centrala: 018/4155055 opcija 2 tehnička pitanja, opcija 4 finansijska pitanja':'Central: 018/4155055 option 2 technical issues, option 4 financial issues'}}<br>
                            {{App::getLocale() === 'sr-Latn' ?'  SMS/Viber: 065/9410000':' SMS/Viber: 065/9410000'}}<br>
                        </p>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ?'Hvala što koristite NiNet Internet servise.':'Thank you for using Internet DC services.'}}<br>
                        </p>
                    </div>
                </div>

                @include('partials.side-tech')

            </div>
        </div>
    </section>
@endsection