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
                        <p class="text1 text-uppercase">{{ __('main.order_success_1') }}</p>
                        <p class="text2">{{ __('main.order_success_2') }} </p>
                        <p class="text3">{{ __('main.order_success_3') }}: <br />
                            <a href="tel:{{ __('company.webglobe_phone') }}" class="phone">{{ __('company.webglobe_phone') }}</a> {{ __('main.order_success_3_or') }} <a href="mailto:helpdesk@webglobe.rs">helpdesk@webglobe.rs</a>
                        </p>
                        @if(isset(CartContact::get()->customerId))
                            <div class="my-pages-links">
                                <a href="javascript:void(0)">Moje kupovine</a>
                                <a href="javascript:void(0)">Moj profil</a>
                                <a href="javascript:void(0)">Podrška</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="image">
                        <img src="{{ url('assets/images/purchased.png') }}" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection