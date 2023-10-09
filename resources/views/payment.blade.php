@extends('layouts.master-dc')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ url('/assets/no_bower_components/bootstrap-social/bootstrap-social.css') }}">
    <style>
        .price span {
            font-size: 100% !important;
        }
    </style>
@endsection

@section('head-scripts')
    {!! NoCaptcha::renderJs(App::getLocale() === 'sr-Latn' ? 'sr' : 'en') !!}
@endsection

@section('content')

    @php
        $currency = App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;';
    @endphp
    <section class="page-top-part">
        <div class="container">

            <div class="page-title-block">
                <ul class="buying-process-menu">
                    <li class="active text-uppercase"><a href="javascript:void(0)">{{ __('main.payment') }}</a></li>
                </ul>
            </div>

        </div>
    </section>
    <section class="bp-register-section">
        <div class="container">
            @if(session()->has('error_message'))
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="alert alert-danger">
                            {{ session('error_message') }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="cart-table" id="cart_table_div">
                @include('partials.payments-cart')
            </div>

            <div class="row mt-2">
                <div class="col-lg-5">
                    <div class="block-t1">
                        <div class="block-title">
                            {{ __('main.promo_code') }}
                        </div>
                        <div class="block-content">
                            <div class="vps-add-hostname">
                                <input type="text" placeholder="{{ __('main.promo_code') }}" id="promo_code_field">
                                <button type="button" class="cursor-pointer add-hostname" id="apply_promo_code">{{ __('main.apply') }}</button>
                            </div>
                        </div>
                        <div id="promo_code_message_holder" class="text-danger" style="margin: 0 5px"></div>
                        <div id="promo_code_success_holder" class="text-success" style="margin: 0 5px"></div>
                    </div>
                </div>
            </div>

            <form action="{{ route('payment.redirect') }}" id="payment_redirect_form" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-5">
                        <div class="blue-title-block">{{ __('main.personal_data') }}</div>
                        <br>
                        @php
                            $mainContact = CartContact::get();
                        @endphp
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="auth-user-data-block total">
                                    <p><span class="text-bold">{{ __('main.name_last_name') }}: &nbsp;</span>{{ $mainContact->firstName }} {{ $mainContact->lastName }}</p>
                                    @if( ! empty($mainContact->companyName))
                                        <p><span class="text-bold">{{ __('main.company') }}: &nbsp;</span>{{ $mainContact->companyName }}</p>
                                        <p><span class="text-bold">{{ __('main.company_registration_number') }}: &nbsp;</span>{{ $mainContact->companyRegistrationNumber }}</p>
                                        <p><span class="text-bold">{{ __('main.company_tax_number') }}: &nbsp;</span>{{ $mainContact->companyTaxNumber }}</p>
                                    @endif
                                    <p><span class="text-bold">{{ __('main.address') }}: &nbsp;</span>{{ $mainContact->address }}</p>
                                    <p><span class="text-bold">{{ __('main.postal_code') }}: &nbsp;</span>{{ $mainContact->postalCode }}</p>
                                    <p><span class="text-bold">{{ __('main.city') }}: &nbsp;</span>{{ $mainContact->city }}</p>
                                    <p><span class="text-bold">{{ __('main.country') }}: &nbsp;</span>{{ $mainContact->countryName }}</p>
                                    <p><span class="text-bold">{{ __('main.contact_phone') }}: &nbsp;</span>{{ $mainContact->phone }}</p>
                                    <p><span class="text-bold">{{ __('main.email_address') }}: &nbsp;</span>{{ $mainContact->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $euro = \App\Models\Currency::where('code', 'EUR')->first();
                        $rsd = \App\Models\Currency::where('code', 'RSD')->first();

                        $exchangeRate = \App\Models\ExchangeRate::where('currency_from', $euro->id)
                            ->where('currency_to', $rsd->id)
                            ->orderBy('currency_date', 'desc')
                            ->first()['rate'];
                    @endphp
                    <div class="push-lg-1 col-lg-6">

                        <div class="blue-title-block"><span style="color: #ec971f ">* </span>{{ __('main.payment_type') }}</div>

                        <div class="payment-block">

                            <div class="radio-box" data-radio="block">
{{--                                @if(App::getLocale() === 'sr-Latn')--}}
                                    <div>
                                        <input type="radio" name="payment" value="card_payment" id="card_payment" data-toggle="modal" data-target="#exampleModal">
                                        <label class="" for="card_payment">{{ __('main.with_card') }}</label>
                                        @if(App::getLocale() === 'en')
                                            <p style="padding-left: 25px; font-size: small">
                                                The conversion is done with respect to the current exchange rate of the National Bank of Serbia and relevant card associations. The user of the payment card is debited in the currency of the account to which their card is linked. As a result of the conversion, there is a possibility that the charged amount will differ from the amount on the online point of sale.<br>
                                                Middle exchange rate National Bank of Serbia:<br>
                                                €1= {{ $exchangeRate * 1 }} RSD
                                            </p>
                                        @endif
                                    </div>
{{--                                @endif--}}

                                {{-- Payment options for foreign users --}}
                                @if(App::getLocale() === 'en')
{{--                                    <div>--}}
{{--                                        <input type="radio" name="payment" value="2co_payment" id="2co_payment" data-payment-link="">--}}
{{--                                        <label for="2co_payment">2Checkout</label>--}}
{{--                                        <div class="payment-icons">--}}
{{--                                            <img src="{{ url('assets/images/2checkout-payment.png') }}" width="128px" alt=""/>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    @if($mainContact->email === 'milan.radovanovic@ninet.co.rs')
                                        <div>
                                            <input type="radio" name="payment" value="paypal_payment" id="paypal_payment" data-payment-link="{{ route('paypal.express') }}">
                                            <label for="paypal_payment">PayPal</label>
                                            <div class="payment-icons">
                                                <img src="{{ url('assets/images/payment5.png') }}" alt=""/>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <div>
                                    <input type="radio" name="payment" value="pre-invoice" id="pre-invoice">
                                    <label for="pre-invoice">{{ __('main.pre_invoice') }}</label>
                                </div>
                                <div class="text-danger payment_option_error errors-container">
                                    @if($errors->has('payment'))
                                        <ul>
                                            @foreach($errors->get('payment') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                {{-- / Payment options for foreign users --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="checkboxes-block margin-t clearfix">
                            <div class="checkbox left" data-checkbox="block">
                                <input type="checkbox" class="checkbox-toggler" id="notify_email">
                                <input type="hidden" name="notify_email" value="1">
                                <label for="notify_email" class="">{{ __('main.notify_email_info') }}</label>
                            </div>
                            <div class="checkbox left" data-checkbox="block">
                                <input type="checkbox" name="phone_notification" class="checkbox-toggler" id="phone_notification">
{{--                                <input type="hidden" name="phone_notification" value="false">--}}
                                <label for="phone_notification" class="">{{ __('main.phone_notification') }}</label>
                            </div>
                            <div class="checkbox left {{ $errors->has('terms_and_conditions') ? 'text-danger' : '' }}" data-checkbox="block">
                                <input type="checkbox" class="{{ $errors->has('terms_and_conditions') ? 'has-errors' : '' }}" id="terms-and-conditions" name="terms_and_conditions">
                                <label for="terms-and-conditions" class="">
                                    <span style="color: #ec971f ">* </span>{{ __('main.terms_and_conditions_agree_1') }}
                                    <a href="{{ route('page.terms-and-conditions') }}" target="_blank" class="text-warning text-bold">{{ __('main.terms_and_conditions_agree_2') }}</a>
                                    {{ __('main.and') }}
                                    <a href="{{ route('page.privacy-policy') }}" target="_blank" class="text-warning text-bold">{{ __('main.terms_and_conditions_agree_3') }}</a>
                                </label>
                                <div class="text-danger terms_and_conditions_error errors-container">
                                    @if($errors->has('terms_and_conditions'))
                                        <ul>
                                            @foreach($errors->get('terms_and_conditions') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4">
                        <div class="recaptcha">{!! NoCaptcha::display() !!}</div>
                        <div class="text-danger recaptcha_error errors-container">
                            @if($errors->has('g-recaptcha-response'))
                                <ul>
                                    @foreach($errors->get('g-recaptcha-response') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <button type="submit" class="btn-t1 full-width text-center">{{ __('main.complete_purchase') }}<span class="fa fa-cart-arrow-down"></span></button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <a href="" target="_blank">
                            <img src="{{ url('images/raiffeisen-logo.png') }}" alt="Raiffeisen">
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="payment-icons flexbox">
                            <img src="{{ url('images/mc_acc_opt_70_1x.png') }}" style="width: 60px !important;" alt="MasterCard">
                            <img src="{{ url('images/ms_acc_opt_70_1x.png') }}" style="width: 60px !important;" alt="Maestro">
                            <img src="{{ url('images/visa_pos_fc.png') }}" style="width: 60px !important;" alt="Visa">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <a href="https://www.mastercard.rs/sr-rs/consumers/find-card-products/credit-cards.html" target="_blank" class="pull-right mr-1">
                            <img src="{{ url('images/sclogo_156x83.gif') }}" style="height: 58px !important;" alt="MasterCard Secure Code">
                        </a>
                        <a href="https://rs.visa.com/pay-with-visa/security-and-assistance/protected-everywhere.html" target="_blank" class="pull-right mr-1">
                            <img src="{{ url('images/Ver-by-VBM-2c-JPG.jpg') }}" style="height: 58px !important;" alt="Verified By Visa">
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>

    <div style="visibility: hidden" id="nestpay_form_holder">

    </div>

    <div id="blockMessage" style="display:none;">
        <h4>{{ __('main.request_processing') }}</h4> <br>
        <span class="fa fa-spinner fa-spin fa-3x"></span>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('main.notification') }}</h5>
                        <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __('main.card_payment_notification') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('/assets/no_bower_components/jquery.blockUI.js') }}"></script>
    <script>
        var _nestpay_form_url = '{{ route('raiffeisen.form') }}';
        var _payment_validation_url = '{{ route('payment.validation') }}';
        var _apply_promo_code_url = '{{ route('promo-code.apply') }}';
        var _get_payments_cart_view_url = '{{ route('cart.get-payments-view') }}';
        var _get_cart_view_url = '{{ route('cart.get-view') }}';
    </script>
    <script src="{{ url(mix('js/payment.js')) }}"></script>
    <style>
    #phone_notification {
        width:76px;
    }
    </style>
@endsection