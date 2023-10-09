@extends('layouts.page-dc')

@section('page-title')
   {{ __('main.delivery_policy') }}
@endsection

@section('page-content')

    <section class="simple-page">
        <div class="container">
            <div class="text-style">
                <h2><span class="text-primary">{{ App::getLocale() === 'sr-Latn' ? 'Rok isporuke usluga ' : 'Delivery policy' }}<br></span> </h2>
                <p>{{ App::getLocale() === 'sr-Latn' ? 'Webglobe se obavezuje da će isporuči uslugu koja je naručena i plaćena bez nepotrebnog odlaganja, osim u situacijama koje mogu nastati a na koje nisu pod kontrolom Webglobe-a. Većina naših usluga (VPS, WebHosting...) se automatski pružaju i isporučuju se, u većini slučajeva, instant' : 'Webglobe undertakes to deliver services purchased and paid for without undue delay, excluding situations where there are external circumstances beyond our control affecting the delivery of service. A number of our services (VPS, WebHosting,...) are automatically provisioned, and will be delivered, in most of the cases, instantly.' }}</p><br>
                <p>{{ App::getLocale() === 'sr-Latn' ? 'Ispod je navedeno vreme koje je potrebno kako bi se usluge isporučile, ukoliko nisu automatski isporučene, nakon što je uplata primljena u celosti' : 'Typical lead times for services that are not automatically provisioned, once payment has been received in full, are below:' }}</p>
                <p>{{ App::getLocale() === 'sr-Latn' ? '• WebHosting – 1 do 24 h' : '• WebHosting – 1 to 24 hours' }}</p>
                <p>{{ App::getLocale() === 'sr-Latn' ? '• Registracija domena – 1 do 48 h' : '• Domain name registration – 1 to 48 hours' }}</p>
                <p>{{ App::getLocale() === 'sr-Latn' ? '• Namenski serveri – 1 do 20 dana' : '• Dedicated servers – 1 to 20 days' }}</p>
                <p>{{ App::getLocale() === 'sr-Latn' ? '• “Custom build” Namenski serveri – 3 do 20 dana' : '• “Custom build” Dedicated servers – 3 to 20 days' }}</p>
                <p>{{ App::getLocale() === 'sr-Latn' ? '• VPS – 1 do 24 h' : '• VPS – 1 to 24 hours' }}</p>
                <p>{{ App::getLocale() === 'sr-Latn' ? '• SSL sertifikati – 1 do 7 dana' : '• SSL certificates – 1 to 7 days' }}</p>
                <p>{{ App::getLocale() === 'sr-Latn' ? 'Molimo da uzmete u obzir da su ovo samo smernice. Ukoliko želite detaljnije informacije o vremenu isporuke za izvršenu narudžbinu ili usluga nije navedena, molimo da nas kontaktirat' : 'Please note that these are guidelines only. If you require a more specific timescale for your ordered service, or your service is not listed, please ask your designated account manager or sales representative.' }}</p>
            </div>
        </div>
    </section>
@endsection