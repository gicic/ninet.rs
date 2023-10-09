@extends('layouts.master-dc')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@php
    $payment = session('payment');
    $order = session('order');
    $customer = $order->customer->getMainContact();
@endphp

@section('content')
    <section class="bp-purchased-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="text">
                        <p class="text1 text-uppercase">{{ __('main.card_payment_fail') }}</p>
                        <p class="text3">{{ __('main.order_success_3') }}: <br />
                            <a href="tel:{{ __('company.phone_1') }}" class="phone">{{ __('company.phone_1') }}</a> {{ __('main.order_success_3_or') }} <a href="mailto:podrska@ninet.rs">podrska@ninet.rs</a>
                        </p>
                        <p>
                            <a href="{{ route('payment.page') }}" class="btn-t1">{{ __('main.try_again') }} <span class="fa fa-dollar"></span></a>
                        </p>
                        @include('raiffeisen.partials.customer')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    @include('raiffeisen.partials.order')
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    @include('raiffeisen.partials.transaction')
                </div>
            </div>


        </div>
    </section>
@endsection