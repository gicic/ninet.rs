@extends('layouts.master')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@php
$payment = session('payment');
$order = session('order');
@endphp

@section('content')
    <section class="bp-purchased-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="text">
                        <p class="text1 text-uppercase">{{ __('main.card_payment_success') }}: {{ number_format($payment['amount'], 2) }} RSD</p>
                        <p class="text2">{{ __('main.order_success_2') }} </p>
                        <p class="text3">{{ __('main.order_success_3') }}: <br />
                            <a href="tel:{{ __('company.phone_1') }}" class="phone">{{ __('company.phone_1') }}</a> {{ __('main.order_success_3_or') }} <a href="mailto:support@ninet.rs">support@ninet.rs</a>
                        </p>
                        @include('nestpay.partials.customer')
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="image">
                        <img src="{{ url('assets/images/purchased.png') }}" alt=""/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    @include('nestpay.partials.order')
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    @include('nestpay.partials.transaction')
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    @include('nestpay.partials.merchant')
                </div>
            </div>
        </div>
    </section>
@endsection