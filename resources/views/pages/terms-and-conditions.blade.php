@extends('layouts.page')

@section('page-title')
    {{ __('main.terms_and_conditions') }}
@endsection

@section('page-content')

    <section class="simple-page">
        <div class="container">
            <div class="text-style">

                <h2>{{ __('privacy-terms.terms_h1') }}</h2>
                <p>{{ __('privacy-terms.terms_h1p1') }}</p>
                <p>{{ __('privacy-terms.terms_h1p2') }}</p>
                <p>{{ __('privacy-terms.terms_h1p3') }}</p>

                <h2>{{ __('privacy-terms.terms_h2') }}</h2>

                <ul>
                    <li><strong>{{ __('privacy-terms.terms_h2_li1_key') }}</strong>{{ __('privacy-terms.terms_h2_li1_value') }}</li>
                    <li><strong>{{ __('privacy-terms.terms_h2_li2_key') }}</strong>{{ __('privacy-terms.terms_h2_li2_value') }}</li>
                    <li><strong>{{ __('privacy-terms.terms_h2_li3_key') }}</strong>{{ __('privacy-terms.terms_h2_li3_value') }}</li>
                    <li><strong>{{ __('privacy-terms.terms_h2_li4_key') }}</strong>{{ __('privacy-terms.terms_h2_li4_value') }}</li>
                    <li><strong>{{ __('privacy-terms.terms_h2_li5_key') }}</strong>{{ __('privacy-terms.terms_h2_li5_value') }}</li>
                    <li><strong>{{ __('privacy-terms.terms_h2_li6_key') }}</strong>{{ __('privacy-terms.terms_h2_li6_value') }}</li>
                    <li><strong>{{ __('privacy-terms.terms_h2_li7_key') }}</strong><a href="https://ninet.rs">https://ninet.rs</a></li>
                    <li><strong>{{ __('privacy-terms.terms_h2_li8_key') }}</strong>{{ __('privacy-terms.terms_h2_li8_value') }}</li>
                    <li><strong>{{ __('privacy-terms.terms_h2_li9_key') }}</strong>{{ __('privacy-terms.terms_h2_li9_value') }}</li>
                </ul>

                <h2>{{ __('privacy-terms.terms_h3') }}</h2>
                <p>{{ __('privacy-terms.terms_h3p1') }}</p>

                <h2>{{ __('privacy-terms.terms_h4') }}</h2>
                <p>{{ __('privacy-terms.terms_h4p1') }}</p>

                <h2>{{ __('privacy-terms.terms_h5') }}</h2>
                <p>{{ __('privacy-terms.terms_h5p1') }}</p>

                <h2>{{ __('privacy-terms.terms_h6') }}</h2>
                <p>{{ __('privacy-terms.terms_h6p1') }}</p>

                <h2>{{ __('privacy-terms.terms_h7') }}</h2>
                <p>{{ __('privacy-terms.terms_h7p1') }}</p>
                <p>{{ __('privacy-terms.terms_h7p2') }}</p>

                <h2>{{ __('privacy-terms.terms_h8') }}</h2>
                <p>{{ __('privacy-terms.terms_h8p1') }}</p>

                <h2>{{ __('privacy-terms.terms_h9') }}</h2>
                <p>{{ __('privacy-terms.terms_h9p1') }}</p>
                <p>{{ __('privacy-terms.terms_h9p2') }}</p>

                <ul>
                    <li>{{ __('privacy-terms.terms_h9_li3') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li4') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li5') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li6') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li7') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li8') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li9') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li10') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li11') }}</li>
                    <li>{{ __('privacy-terms.terms_h9_li13') }}</li>
                </ul>
            </div>
        </div>
    </section>

@endsection