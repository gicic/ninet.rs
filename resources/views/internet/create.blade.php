@extends('layouts.master')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@section('head-scripts')
    {!! NoCaptcha::renderJs(App::getLocale() === 'sr-Latn' ? 'sr' : 'en') !!}
@endsection

@section('content')
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
            <form action="{{ route('internet.store') }}" id="make_order_form" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id_proizvodi }}">

                <div class="row">
                    <div class="col-lg-5">

                        <div class="blue-title-block">{{ __('main.enter_basic_data') }}</div>

                        <p class="notification margin-t"><span class="fw-bold c-yellow">{{ __('main.note') }}:</span> {{ __('main.required_note_1') }} <span class="fa fa-asterisk"></span> {{ __('main.required_note_2') }}</p>

                        <div class="form-element required">
                            <label for="first_name">{{ __('main.first_name') }}</label>
                            <input class="{{ $errors->has('first_name') ? 'has-errors' : '' }}" type="text" name="first_name" id="first_name" placeholder="{{ __('main.first_name') }}:" value="{{ old('first_name') }}">
                            <div class="text-danger">
                                @if($errors->has('email'))
                                    <ul>
                                        @foreach($errors->get('first_name') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element required">
                            <label for="last_name">{{ __('main.last_name') }}</label>
                            <input class="{{ $errors->has('last_name') ? 'has-errors' : '' }}" type="text" name="last_name" id="last_name" placeholder="{{ __('main.last_name') }}:" value="{{ old('last_name') }}">
                            <div class="text-danger">
                                @if($errors->has('email'))
                                    <ul>
                                        @foreach($errors->get('last_name') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element">
                            <label for="last_name">{{ __('main.company') }}</label>
                            <input class="{{ $errors->has('company') ? 'has-errors' : '' }}" type="text" name="company" id="company" placeholder="{{ __('main.company') }}:" value="{{ old('company') }}">
                            <div class="text-danger">
                                @if($errors->has('company'))
                                    <ul>
                                        @foreach($errors->get('company') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element required">
                            <label for="address">{{ __('main.address') }}</label>
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
                            <label for="city">{{ __('main.city') }}</label>
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
                            <label for="phone">{{ __('main.contact_phone') }}</label>
                            <input class="{{ $errors->has('phone') ? 'has-errors' : '' }}" type="text" name="phone" id="phone" placeholder="{{ __('main.phone') }}:" value="{{ old('phone') }}">
                            <div class="text-danger">
                                @if($errors->has('phone'))
                                    <ul>
                                        @foreach($errors->get('phone') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element">
                            <label for="mobile_phone">{{ __('main.mobile_phone') }}</label>
                            <input class="{{ $errors->has('mobile_phone') ? 'has-errors' : '' }}" type="text" name="mobile_phone" id="mobile_phone" placeholder="{{ __('main.mobile_phone') }}:" value="{{ old('mobile_phone') }}">
                            <div class="text-danger">
                                @if($errors->has('mobile_phone'))
                                    <ul>
                                        @foreach($errors->get('mobile_phone') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element required">
                            <label for="email">{{ __('main.email_address') }}</label>
                            <input class="{{ $errors->has('email') ? 'has-errors' : '' }}" type="text" name="email" id="email" placeholder="{{ __('main.email_address') }}:" value="{{ old('email') }}">
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

                        @if($product->id_proizvodi == '367' || $product->id_proizvodi == '368' || $product->id_proizvodi == '369')
                            <label for="email">Izaberi:</label>

                            <div class="radio-box" data-radio="block">
                                <div>
                                    <input type="radio" name="choice" value="Poklon" id="choice_1">
                                    <label for="choice_1">{{'Poklon'}}</label>
                                </div>
                                <div>
                                    <input type="radio" name="choice" value="Popust" id="choice_2">
                                    <label for="choice_2">{{'Dodatni popust'}}</label>
                                </div>
                                <div class="text-danger">
                                    @if($errors->has('choice'))
                                        <ul>
                                            @foreach($errors->get('choice') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="checkbox left" data-checkbox="block">
                            <input type="checkbox" class="checkbox-toggler" id="have_equipment" name="have_equipment" {{ old('have_equipment') === 'on' ? 'checked' : '' }}>
                            <label for="have_equipment" class="{{ old('have_equipment') === 'on' ? 'active' : '' }}">Već imam svoju opremu</label>
                        </div>

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

                    <div class="col-lg-5 col-lg-offset-1" style="display: {{ old('have_equipment') === 'on' ? 'block' : 'none' }}" id="additional_holder">

                        <div class="blue-title-block">Podaci o opremi</div>
                        <br>

                        <div class="form-element">
                            <label for="card_type">Tip/proizvođač wireless uređaja ili PCI wireless kartice:</label>
                            <input class="{{ $errors->has('card_type') ? 'has-errors' : '' }}" type="text" name="card_type" id="card_type" value="{{ old('card_type') }}">
                            <div class="text-danger">
                                @if($errors->has('card_type'))
                                    <ul>
                                        @foreach($errors->get('card_type') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element">
                            <label for="mac_ap">MAC adresa wireless uređaja ako koristite access point (u obliku xx:xx:xx:xx:xx:xx):</label>
                            <input class="{{ $errors->has('mac_ap') ? 'has-errors' : '' }}" type="text" name="mac_ap" id="mac_ap" value="{{ old('mac_ap') }}">
                            <div class="text-danger">
                                @if($errors->has('mac_ap'))
                                    <ul>
                                        @foreach($errors->get('mac_ap') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element">
                            <label for="mac_lan">MAC adresa LAN kartice u računaru na koji je uređaj uključen (u obliku xx:xx:xx:xx:xx:xx):</label>
                            <input class="{{ $errors->has('mac_lan') ? 'has-errors' : '' }}" type="text" name="mac_lan" id="mac_lan" value="{{ old('mac_lan') }}">
                            <div class="text-danger">
                                @if($errors->has('mac_lan'))
                                    <ul>
                                        @foreach($errors->get('mac_lan') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element">
                            <label for="mac_card">MAC adresa PCI wireless kartice ako koristite PCI Wireless karticu (u obliku xx:xx:xx:xx:xx:xx):</label>
                            <input class="{{ $errors->has('mac_card') ? 'has-errors' : '' }}" type="text" name="mac_card" id="mac_card" value="{{ old('mac_card') }}">
                            <div class="text-danger">
                                @if($errors->has('mac_card'))
                                    <ul>
                                        @foreach($errors->get('mac_card') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element">
                            <label for="ssid">SSID naše bazne stanice koju najbolje "vidite" pri skeniranju mreža (u obliku ninetxx):</label>
                            <input class="{{ $errors->has('ssid') ? 'has-errors' : '' }}" type="text" name="ssid" id="ssid" value="{{ old('ssid') }}">
                            <div class="text-danger">
                                @if($errors->has('ssid'))
                                    <ul>
                                        @foreach($errors->get('ssid') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-element">
                            <label for="signal">Signal stanice ninetxx (u %):</label>
                            <input class="{{ $errors->has('signal') ? 'has-errors' : '' }}" type="text" name="signal" id="signal" value="{{ old('signal') }}">
                            <div class="text-danger">
                                @if($errors->has('signal'))
                                    <ul>
                                        @foreach($errors->get('signal') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
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
                        <button type="submit" class="btn-t1 full-width text-center">{{ __('main.send_request') }}<span class="fa fa-cart-arrow-down"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ url(mix('/js/internet-request.js')) }}"></script>
@endsection