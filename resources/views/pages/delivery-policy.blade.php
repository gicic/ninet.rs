@extends('layouts.page')

@section('page-title')
   {{ __('main.delivery_policy') }}
@endsection

@section('page-content')

    <section class="simple-page">
        <div class="container">
            <div class="text-style">
                <h2><b>{{ App::getLocale() === 'sr-Latn' ? 'Rok isporuke usluga' : 'Delivery policy' }}</b></h2>
                <p>{{ App::getLocale() === 'sr-Latn' ? 'NiNet se obavezuje da će isporuči uslugu koja je naručena i plaćena bez nepotrebnog odlaganja, osim u situacijama koje mogu nastati a na koje nisu pod kontrolom NiNeta.' : 'NiNet undertakes to deliver services purchased and paid for without undue delay, excluding situations where there are external circumstances beyond our control affecting the delivery of service.' }}</p>
                <p>{{ App::getLocale() === 'sr-Latn' ? 'Ukoliko želite detaljnije informacije o vremenu isporuke za izvršenu narudžbinu, molimo da nas kontaktirate.' : 'If you require a more specific timescale for your ordered service, please ask your designated account manager or sales representative.' }}</p>
            </div>
        </div>
    </section>

@endsection