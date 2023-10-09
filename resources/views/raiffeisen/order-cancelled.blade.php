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
                                {{ 'Narudžbenica nije više aktivna.'}}
                            @else
                                {{ 'The order is no longer active.' }}
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
                                {{ 'Možete kreirati novu porudžbinu ili nas kontaktirajte za više detalja na:' }} <a href="mailto:helpdesk@webglobe.rs"><b>helpdesk@webglobe.rs</b></a>
                            @else
                                {{ 'Please make a new order or contact us for more details at:' }} <a href="mailto:helpdesk@webglobe.rs"><b>helpdesk@webglobe.rs</b></a>
                            @endif
                        </p><br>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection