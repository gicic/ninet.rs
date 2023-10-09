@extends('layouts.page')

@section('page-title')
    {{ __('main.payment_and_refund_policy') }}
@endsection

@section('page-content')

    <section class="simple-page">
        <div class="container">
            <div class="text-style">

                <h2>{{ __('privacy-terms.payment_h1') }}</h2>
                <p>{{ __('privacy-terms.payment_h1p1') }}</p>
                <p>{{ __('privacy-terms.payment_h1p2') }}</p>

                <h2>{{ __('privacy-terms.payment_h2') }}</h2>
                <p>{{ __('privacy-terms.payment_h2p1') }}</p>
                <p>{{ __('privacy-terms.payment_h2p2') }}</p>
            </div>
        </div>
    </section>

@endsection