@extends('layouts.master')

@section('meta')
    <meta name="robots" content="noindex">
    <meta name="google-signin-client_id" content="{{ config('services.google.client_id') }}">
@endsection

@section('head-scripts')
    {!! NoCaptcha::renderJs(App::getLocale() === 'sr-Latn' ? 'sr' : 'en') !!}
@endsection

@section('content')

    <section class="page-top-part">
        <div class="container">
            <div class="page-title-block">
                <ul class="buying-process-menu">
                    <li class="active text-uppercase"><a href="javascript:void(0)">{{ 'Registracija' }}</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="bp-register-section">
        <div class="container">
            <form action="{{route('medianis.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="user-type-select">
                        <div class="row">
                            <div class="col-sm-2">
                                <span class="text">{{ __('main.personal_data') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="checkbox left col-lg-12" data-checkbox="block">
                        <input type="checkbox" {{ old('is_legal_entity') == 'on' ? 'checked' :'' }} {{ old('is_legal_entity') ? 'checked' :'' }}  id="is_legal_entity" name="is_legal_entity">
                        <label for="is_legal_entity" class="">
                            {{'Pravno lice?'}}
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <div class="bp-guest-block" id="customer_info_block" style="display: {{ empty(old('login_guest_select')) || old('login_guest_select') === 'guest' ? 'block' : 'none'}}">
                            <div class="bp-guest">
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
                                <div class="legal-entity">
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
                                @php
                                    $serbia = App\Repositories\CountryRepository::getByCode('RS');
                                @endphp

                                <div class="form-element required">
                                    <select name="country" id="country" class="{{ $errors->has('country') ? 'has-errors' : '' }}">
                                        <option value="">{{ __('main.country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ !empty(old('country')) ? (old('country') == $country->id ? 'selected' : '') : App::getLocale() === 'sr-Latn' ? ($country->id == $serbia->id ? 'selected' : '') : '' }}>{{ $country->name }}</option>
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
                                <div class=" text-style">
                                    <h3>{{ 'E-mail adrese' }}</h3>
                                </div>
                                @for ($i = 1; $i <= 30; $i++)
                                    <div class="form-element email required" id="email{{$i}}">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <input type="text" class="{{ $errors->has('email_addresses.'.($i-1)) ? 'has-errors' : '' }} email{{$i}}" name="email_addresses[]" placeholder="{{ __('main.email_address') }}:" value="{{ old('email_addresses.'.($i-1)) }}">
                                                <small class="text-danger text-bold">{{'Unesite prvi deo mail adrese'}}</small>
                                                <div class="text-danger error{{$i}}">
                                                    @if($errors->has('email_addresses.'.($i-1)))
                                                        <ul>
                                                            @foreach($errors->get('email_addresses.'.($i-1)) as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <input class="" readonly type="text" disabled placeholder="{{ '@medianis.net' }}" >
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <button type="button" id="addEmail" style="border: none" class="btn btn-outline-primary btn-sm borderless pull-left">
                                                <strong> <i class="fa fa-plus"></i> {{ 'Dodaj e-mail adresu' }}</strong>
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" id="removeEmail" style="border: none" class="btn btn-outline-danger btn-sm borderless pull-right">
                                                <strong> <i class="fa fa-minus"></i> {{ 'Ukloni e-mail adresu' }}</strong>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5" style="float: right">
                        <div class="col-md-12 text-center">
                            <h3>{{'Mail paket usluge su sledeće:'}}</h3>
                        </div>
                        <div class="col-md-12 text-style text-center">
                            <h3>{{ '100 MB - Free medianis.net' }}</h3>
                            <p>{{ 'Podrška putem tiketa u roku od 48h, NO Phone calls' }}</p>
                        </div>
                        <div class="col-md-12 text-style text-center">
                            <h3>{{ '1 GB - Basic medianis.net ' }}<strong class="text-danger">{{'599 rsd/god'}}</strong></h3>
                            <p>{{ 'Podrška putem tiketa u roku od 24h, NO Phone calls' }}</p>
                        </div>
                        <div class="col-md-12 text-style text-center">
                            <h3>{{ '15 GB - Pro medianis.net ' }}<strong class="text-danger">{{'1999 rsd/god'}}</strong></h3>
                            <p>{{ 'Podrška putem tiketa u roku od 4h (u toku radnog vremena pon-pet, 8-20h), podrška putem telefona' }}</p>
                        </div>
                        <div class="col-md-12 text-danger text-center">
                            <h4 class="text-bold">{{'UKOLIKO POVRATNA INFORMACIJA PUTEM DOSTAVLJENE FORME BUDE NEPOTPUNA ILI NE BUDE DOSTAVLJENA, SMATRAĆEMO DA SE MAIL NALOG NE KORISTI I ISTI ĆE BITI SUSPENDOVAN, A NAKON 30 DANA I OBRISAN SA SERVERA.'}}</h4>
                        </div>
                    </div>
                </div>

                <div class="radio-box" data-radio="block">
                    <div>
                        <input type="radio" name="mail_package" value="commercial_package" id="mail_package_1">
                        <label for="mail_package_1">{{'Saglasan sam da koristim jedan od komercijalnih paketa - prema zauzeću mog mailbox-a'}}</label>
                    </div>
                    <div>
                        <input type="radio" name="mail_package" value="free_package" id="mail_package_2">
                        <label for="mail_package_2">{{'Ne želim da koristim komercijalne mail pakete, free 100MB je dovoljan'}}</label>
                    </div>
                    <div class="text-danger">
                        @if($errors->has('mail_package'))
                            <ul>
                                @foreach($errors->get('mail_package') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="checkboxes-block margin-t clearfix">
                        <div class="checkbox left {{ $errors->has('terms_and_conditions') ? 'text-danger' : '' }}" data-checkbox="block">
                            <input type="checkbox" class="{{ $errors->has('terms_and_conditions') ? 'has-errors' : '' }}" id="terms-and-conditions" name="terms_and_conditions">
                            <label for="terms-and-conditions" class="">
                                {{ __('main.terms_and_conditions_agree_1') }}
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
                <div class="col-xs-4">
                    {!! NoCaptcha::display() !!}
                    <div class="text-danger recaptcha_error">
                        @if($errors->has('g-recaptcha-response'))
                            <ul>
                                @foreach($errors->get('g-recaptcha-response') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="col-xs-12">
                    <button type="submit" class="btn-t1" id="submit">{{ 'Završi Registraciju' }}</button>
                </div>
            </form>
        </div>
    </section>
    @include('partials.success')

@endsection

@section('scripts')
    <script>
        var _get_dial_code_url = '{{ route('purchase.dial-code') }}';
    </script>
    <script src="{{ url(mix('/js/medianis.js')) }}"></script>
@endsection