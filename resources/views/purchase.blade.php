@extends('layouts.master-dc')

@section('meta')
    <meta name="robots" content="noindex">
    <meta name="google-signin-client_id" content="{{ config('services.google.client_id') }}">
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
                    <li class="active text-uppercase"><a href="javascript:void(0)">{{ __('main.registration_and_purchase') }}</a></li>
                </ul>
            </div>

        </div>
    </section>

    <section class="bp-register-section">
        <div class="container">
            @if($errors->has('order-error'))
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->get('order-error') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="cart-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('main.product') }}</th>
                        <th>{{ __('main.price') }}</th>
                        <th>{{ __('main.discount') }} %</th>
                        <th>{{ __('main.unit_price') }}</th>
                        <th>{{ __('main.accounting_period') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Cart::mainItems() as $item)
                        @php $itemTotalPrice = $item->total; @endphp
                        <tr>
                            <td data-field-name="Proizvod">
                                <div class="text2">
                                    <span class="text-bold">{{ $item->name }}</span>  {{ $item->total }} {!! $currency !!}
                                </div>
                                @foreach(Cart::additionalItems($item->rowId) as $additionalItem)
                                    @php $itemTotalPrice += $additionalItem->total; @endphp
                                    <div class="additional-item ml-1" data-cart-additional-item-id="{{ $additionalItem->rowId }}">
                                        <span>{{ $additionalItem->name }} (x{{ $additionalItem->qty }})</span>
                                        <span class="additional-item-price">{{ $additionalItem->total }} {!! $currency !!}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td data-field-name="Cena" class="price"><div><span>{{ $itemTotalPrice }}{!! $currency !!}</span></div></td>
                            <td data-field-name="Popust %">{{ $item->discountPercentage }}<span></span></td>
                            <td data-field-name="Jedinična Cena" class="price" data-cart-item-price="{{ $item->rowId }}"><div><span>{{ $item->price }}{!! $currency !!}</span></div></td>
                            <td data-field-name="Period Obračuna"><span>{{ $item->period }} {{ $item->periodFullText }}</span></td>
                            <td data-field-name="" class="delete" data-purchase="delete" data-cart-id="{{ $item->rowId }}"><a href="#" class="fa fa-trash-o"></a></td>
                        </tr>
                    @endforeach

                    <tr class="total">
                        <td colspan="4">
                            {{ __('main.total_for_payment') }}
                        </td>
                        <td class="total-price">
                            <span class="total-price-price">{{ Cart::total() }}</span> <span class="total-price-currency">{!! $currency !!}</span>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <form action="{{ route('purchase.finalize') }}" id="make_order_form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-5">

                        <div class="blue-title-block">{{ __('main.enter_basic_data') }}</div>

                        <p class="notification margin-t"><span class="fw-bold c-yellow">{{ __('main.note') }}:</span> {{ __('main.required_note_1') }} <span class="fa fa-asterisk"></span> {{ __('main.required_note_2') }}</p>

                        <div class="form-element select-holder">
                            <select id="login-register-select" name="login_guest_select">
                                <option value="guest" {{ old('login_guest_select') === 'guest' ? 'selected' : '' }}>{{ __('main.guest') }}</option>
                                <option value="log" {{ old('login_guest_select') === 'log' ? 'selected' : '' }}>{{ __('main.login') }}</option>
                            </select>
                        </div>

                        <div class="bp-login-block" style="display: {{ old('login_guest_select') === 'log' ? 'block' : 'none' }}">
                            <div class="bp-login" id="purchase_login_form">

                                <div class="form-element required">
                                    <input type="email" name="user_login_email" id="user_login_email" placeholder="{{ __('main.email_address') }}" {{ old('user_login_email') }})>
                                    <div class="text-danger email-error-block">
                                        @if($errors->has('user_login_email'))
                                            <ul>
                                                @foreach($errors->get('user_login_email') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-element required">
                                    <input type="password" name="user_login_password" id="user_login_password" placeholder="{{ __('main.password') }}">
                                    <div class="text-danger email-error-block">
                                        @if($errors->has('user_login_password'))
                                            <ul>
                                                @foreach($errors->get('user_login_password') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        {{--                                        <a data-slide-trigger="forgotten-pass" class="forgotten-pass-trigger">{{ __('main.forgotten_password') }}?</a>--}}
                                        @if(App::getLocale() === 'sr-Latn')
                                            <a href="https://cp.ninet.rs/sr-Latn/password/reset" target="_blank" class="forgotten-pass-trigger">{{ __('main.forgotten_password') }}?</a>
                                        @else
                                            <a href="https://cp.ninet.rs/en/password/reset" target="_blank" class="forgotten-pass-trigger">{{ __('main.forgotten_password') }}?</a>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <!--<button class="btn-t1 fl-right">Prijavi se<span class="fa fa-user"></span></button>-->
                                        <button type="button" id="user_login_submit" class="btn-t1 fl-right">{{ __('main.login') }}<span class="fa fa-user"></span></button>
                                    </div>
                                </div>

                            </div>
                            {{--                            <div data-slide-content="forgotten-pass" class="clearfix forgotten-pass">--}}
                            {{--                                <div class="form-element required">--}}
                            {{--                                    <input type="email" placeholder="{{ __('main.email_address') }}" id="email_forgotten">--}}
                            {{--                                </div>--}}
                            {{--                                <button type="button" class="btn-t1 fl-right">{{ __('main.send') }}<span class="fa fa-envelope"></span></button>--}}
                            {{--                            </div>--}}
                        </div>

                        <div class="bp-guest-block" id="customer_info_block" style="display: {{ empty(old('login_guest_select')) || old('login_guest_select') === 'guest' ? 'block' : 'none'}}">
                            <div class="bp-guest">
                                <div class="user-type-select">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <span class="text">{{ __('main.personal_data') }}</span>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="radio-box" data-radio="block">
                                                <div>
                                                    <input type="radio" name="user_type_guest" value="individual_guest" id="individual_guest" {{ (!empty($customerType) && $customerType == 'legal' ? 'disabled' : '') }} {{ (empty(old('user_type_guest')) && empty($customerType)) || (!empty($customerType) && $customerType == 'individual') || old('user_type_guest') === 'individual_guest' ? 'checked' : '' }}>
                                                    <label class="{{ (empty(old('user_type_guest')) && empty($customerType)) || (!empty($customerType) && $customerType == 'individual') || old('user_type_guest') === 'individual_guest' ? 'active' : '' }}" for="individual_guest">{{ __('main.individual_person') }}</label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="user_type_guest" value="legal_entity_guest" id="legal_entity_guest" {{ (!empty($customerType) && $customerType == 'individual' ? 'disabled' : '') }} {{ old('user_type_guest') === 'legal_entity_guest' || (!empty($customerType) && $customerType == 'legal') ? 'checked' : '' }}>
                                                    <label class="{{ old('user_type_guest') === 'legal_entity_guest' || (!empty($customerType) && $customerType == 'legal') ? 'active' : '' }}" for="legal_entity_guest">{{ __('main.legal_entity') }}</label>
                                                </div>
                                            </div>
                                            @if(!empty($customerType))
                                                <div>
                                                    <span class="text-danger">{{ __('main.' . ($customerType === 'legal' ? 'co_rs_info' : 'in_rs_info')) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-element required">
                                    <input class="{{ $errors->has('first_name') ? 'has-errors' : '' }}" type="text" name="first_name" id="first_name" placeholder="{{ __('main.first_name') }}:" value="{{ old('first_name') }}">
                                    <div class="text-danger">
                                        @if($errors->has('first_name'))
                                            <ul>
                                                @foreach($errors->get('first_name') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-element required">
                                    <input class="{{ $errors->has('last_name') ? 'has-errors' : '' }}" type="text" name="last_name" id="last_name" placeholder="{{ __('main.last_name') }}:" value="{{ old('last_name') }}">
                                    <div class="text-danger">
                                        @if($errors->has('last_name'))
                                            <ul>
                                                @foreach($errors->get('last_name') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-element required">
                                    <input class="{{ $errors->has('email') ? 'has-errors' : '' }}" type="email" name="email" id="email" placeholder="{{ __('main.email_address') }}:" value="{{ old('email') }}">
                                    <div class="text-danger">
                                        @if($errors->has('email'))
                                            <ul>
                                                @foreach($errors->get('email') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div id="company-data-holder-guest" style="display: {{ old('user_type_guest') === 'legal_entity_guest' || (!empty($customerType) && $customerType == 'legal') ? 'block' : 'none' }}">
                                    <div class="form-element required">
                                        <input class="{{ $errors->has('company_name') ? 'has-errors' : '' }}" type="text" name="company_name" id="company_name" placeholder="{{ __('main.company') }}:" value="{{ old('company_name') }}">
                                        <div class="text-danger">
                                            @if($errors->has('company_name'))
                                                <ul>
                                                    @foreach($errors->get('company_name') as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-element required">
                                        <input class="{{ $errors->has('company_registration_number') ? 'has-errors' : '' }}" type="text" name="company_registration_number" id="company_registration_number" placeholder="{{ __('main.company_registration_number') }}:" value="{{ old('company_registration_number') }}">
                                        <div class="text-danger">
                                            @if($errors->has('company_registration_number'))
                                                <ul>
                                                    @foreach($errors->get('company_registration_number') as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-element required">
                                        <input class="{{ $errors->has('company_tax_number') ? 'has-errors' : '' }}" type="text" name="company_tax_number" id="company_tax_number" placeholder="{{ __('main.company_tax_number') }}:" value="{{ old('company_tax_number') }}">
                                        <div class="text-danger">
                                            @if($errors->has('company_tax_number'))
                                                <ul>
                                                    @foreach($errors->get('company_tax_number') as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $serbia = App\Repositories\CountryRepository::getByCode('RS');
                                @endphp

                                <div class="form-element required">
                                    <select name="country" id="country" class="{{ $errors->has('country') ? 'has-errors' : '' }}">
                                        <option value="">{{ __('main.country') }}</option>
                                        @foreach($countries as $country)
                                            @if(App::getLocale() === 'sr-Latn')
                                                <option value="{{ $country->id }}" {{ !empty(old('country')) ? (old('country') == $country->id ? 'selected' : '') : App::getLocale() === 'sr-Latn' ? ($country->id == $serbia->id ? 'selected' : '') : '' }}>{{ $country->name }}</option>
                                            @else
                                                @if($country->code !== 'RS')
                                                    <option value="{{ $country->id }}" {{ !empty(old('country')) ? (old('country') == $country->id ? 'selected' : '') : App::getLocale() === 'sr-Latn' ? ($country->id == $serbia->id ? 'selected' : '') : '' }}>{{ $country->name }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="text-danger">
                                        @if($errors->has('country'))
                                            <ul>
                                                @foreach($errors->get('country') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-element required">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <input type="text" id="dial_code" readonly value="{{ !empty(old('country')) ? $countries->where('id', old('country'))->first()->dial_code : (App::getLocale() === 'sr-Latn' ? $countries->where('id', $serbia->id)->first()->dial_code : '') }}">
                                        </div>
                                        <div class="col-xs-9">
                                            <input class="{{ $errors->has('phone') ? 'has-errors' : '' }}" type="text" name="phone" id="phone" placeholder="{{ __('main.contact_phone') }}:" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="text-danger">
                                        @if($errors->has('phone') || $errors->has('dial_code'))
                                            <ul>
                                                @foreach($errors->get('phone') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-element required">
                                    <input class="{{ $errors->has('city') ? 'has-errors' : '' }}" type="text" name="city" id="city" placeholder="{{ __('main.city') }}:" value="{{ old('city') }}">
                                    <div class="text-danger">
                                        @if($errors->has('city'))
                                            <ul>
                                                @foreach($errors->get('city') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-element required">
                                    <input class="{{ $errors->has('address') ? 'has-errors' : '' }}" type="text" name="address" id="address" placeholder="{{ __('main.address') }}:" value="{{ old('address') }}">
                                    <div class="text-danger">
                                        @if($errors->has('address'))
                                            <ul>
                                                @foreach($errors->get('address') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-element required">
                                    <input class="{{ $errors->has('postal_code') ? 'has-errors' : '' }}" type="text" name="postal_code" id="postal_code" placeholder="{{ __('main.postal_code') }}:" value="{{ old('postal_code') }}">
                                    <div class="text-danger">
                                        @if($errors->has('postal_code'))
                                            <ul>
                                                @foreach($errors->get('postal_code') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="auth-user-data-block total" style="display:none;">
                            <p id="first_name_info"></p>
                            <p id="last_name_info"></p>
                            <p id="email_info"></p>
                            <p id="phone_info"></p>
                            <p id="company_name_info"></p>
                            <p id="company_registration_number_info"></p>
                            <p id="company_tax_number_info"></p>
                            <p id="country_info"></p>
                            <p id="city_info"></p>
                            <p id="address_info"></p>
                            <p id="postal_code_info"></p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-8">
                        <button type="submit" class="btn-t1 full-width">{{ __('main.proceed_to_payment') }}<span class="fa fa-cart-arrow-down"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        var _purchase_login_url = '{{ route('purchase.login') }}';
        var _get_dial_code_url = '{{ route('purchase.dial-code') }}';
    </script>
    <script src="{{ url(mix('/js/purchase.js')) }}"></script>
@endsection