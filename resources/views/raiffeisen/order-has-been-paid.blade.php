@extends('layouts.master-dc')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@section('content')
    <section class="bp-purchased-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="text">
                        <p class="text1 text-uppercase">
                            @if($lang == true)
                                {{ 'Narudžbenica je već plaćena.'}}
                            @else
                                {{ 'The purchase order has already been paid for.' }}
                            @endif
                        </p>
                        <p class="text2 text-uppercase">
                            @if($lang == true)
                                {{ 'Ne možete izvrišiti uplatu za ovu narudžbenicu.'}}
                            @else
                                {{ 'You cannot make a payment for this purchase order.' }}
                            @endif
                        </p>
                        <p class="text3">
                            @if($lang == true)
                                {{ 'Ukoliko imate pitanja slobodno nas kontaktirajte na:' }} <a href="mailto:helpdesk@webglobe.rs"><b>helpdesk@webglobe.rs</b></a>
                            @else
                                {{ 'If You have any questions, feel free to contact us on:' }} <a href="mailto:helpdesk@webglobe.rs"><b>helpdesk@webglobe.rs</b></a>
                            @endif
                        </p><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    @include('raiffeisen.partials.order')
                </div>
            </div>
        </div>
    </section>
@endsection