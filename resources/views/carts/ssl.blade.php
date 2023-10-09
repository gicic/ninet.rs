@extends('layouts.master-dc')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@section('content')
    <section class="offer-section">
        <div class="container">
            <div class="tab-t5-holder">
                <!-- Nav tabs -->
                <ul class="tab-t5">
                    <li class="active">
                        <a>
                            {{ $product->name }}
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="row">
                        <form action="{{ route('ssl.add-to-cart') }}" method="post">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="col-lg-8">
                                <div class="block-t1">
                                    <div class="block-title">
                                        {{ __('main.enter_domain') }}
                                    </div>
                                    <div class="block-content">
                                        <div class="vps-add-hostname">
                                            <input type="text" placeholder="{{ __('main.your_domain') }}" name="ssl_domain" id="ssl_domain" data-is-wildcard="{{ !empty($product->sslSecurityLevel->wildcard) ? boolval($product->sslSecurityLevel->wildcard) : false }}" value="{{ empty(old('ssl_domain')) && !empty($product->sslSecurityLevel->wildcard) && $product->sslSecurityLevel->wildcard == 1 ? '*.' : '' }}{{ old('ssl_domain') }}">
                                            <div id="domain_error_block" class="text-danger pl-1">
                                                @if($errors->has('ssl_domain'))
                                                    @foreach($errors->get('ssl_domain') as $error)
                                                        <p>{{ $error }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="block-t1">
                                    <div class="block-title">
                                        {{ __('main.csr_generation') }}
                                    </div>
                                    <div class="block-content">
                                        <div class="form-holder p10">
                                            <div class="select-holder">
                                                <label for="ssl_period">{{ __('main.number_of_years') }}:</label>
                                                <select name="ssl_period" id="ssl_period" class="{{ $errors->has('ssl_period') ? 'has-errors' : '' }}">
                                                    @foreach($periods as $period)
                                                        <option value="{{ $period->id }}" {{ old('ssl_period') == $period->id ? 'selected' : '' }}>{{ $period->period_text }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="period_error_block" class="text-danger">
                                                @if($errors->has('ssl_period'))
                                                    @foreach($errors->get('ssl_period') as $error)
                                                        <p>{{ $error }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        @php
                                        if(!empty(old('ssl_domain'))) {
                                            $domain = ltrim(old('ssl_domain'), '*.');
                                            $domainParts = explode('.', $domain);

                                            if(count($domainParts) === 2) {
                                                $domainForEmail = implode('.', $domainParts);
                                            }

                                            if(count($domainParts) === 3) {
                                                $domainForEmail = $domainParts[1] . '.' . $domainParts[2];
                                                $subdomainForEmail = implode('.', $domainParts);
                                            }

                                            if (count($domainParts) === 4) {
                                                $domainForEmail = $domainParts[1] . '.' . $domainParts[2] . '.' . $domainParts[3];
                                                $subdomainForEmail = implode('.', $domainParts);
                                            }
                                        }
                                        @endphp

                                        <div class="form-holder p10">
                                            <div class="select-holder">
                                                <label for="ssl_confirmation_email">{{ __('main.confirmation_email') }}:</label>
                                                <select name="ssl_confirmation_email" id="ssl_confirmation_email" class="{{ $errors->has('ssl_confirmation_mail') ? 'has-errors' : '' }}">
                                                    @include('carts.partials.ssl-mail')
                                                </select>
                                            </div>
                                            <div id="confirmation_email_error_block" class="text-danger">
                                                @if($errors->has('ssl_confirmation_email'))
                                                    @foreach($errors->get('ssl_confirmation_email') as $error)
                                                        <p>{{ $error }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-holder p10">
                                            <div class="select-holder">
                                                <label for="ssl_server_platform">{{ __('main.server_platform') }}:</label>
                                                <select name="ssl_server_platform" id="ssl_server_platform">
                                                    <option value="">- -</option>
                                                    @foreach($serverPlatforms as $platform)
                                                        <option value="{{ $platform->id }}" {{ old('ssl_server_platform') == $platform->id ? 'selected' : '' }}>{{ $platform->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="server_platform_error_block" class="text-danger">
                                                @if($errors->has('ssl_server_platform'))
                                                    @foreach($errors->get('ssl_server_platform') as $error)
                                                        <p>{{ $error }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="radio-box hosting-domain-availability-radio" data-radio="block">
                                            <div>
                                                <input type="radio" name="radio-csr-choice" value="auto" id="autoCSR" {{ empty(old('radio-csr-choice')) || old('radio-csr-choice') == 'auto' ? 'checked' : '' }}>
                                                <label class="{{ empty(old('radio-csr-choice')) || old('radio-csr-choice') == 'auto' ? 'active' : '' }}" for="autoCSR">{{ __('main.auto_generation') }}</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="radio-csr-choice" value="existing" id="existingCSR" {{ old('radio-csr-choice') == 'existing' ? 'checked' : '' }}>
                                                <label class="{{ old('radio-csr-choice') == 'existing' ? 'active' : '' }}" for="existingCSR">{{ __('main.have_csr') }}</label>
                                            </div>
                                        </div>

                                        <div id="csr_auto_form_holder" style="display:{{ empty(old('csr_code')) ? 'block' : 'none' }};">
                                            <div class="form-holder p10">
                                                <label for="ssl_company">{{ __('main.company_or_name') }}:</label>
                                                <input type="text" name="ssl_company" id="ssl_company" value="{{ old('ssl_company') }}">
                                                <div id="company_error_block" class="text-danger"></div>
                                            </div>
                                            <div class="form-holder p10">
                                                <label for="ssl_department">{{ __('main.department') }}:</label>
                                                <input type="text" name="ssl_department" id="ssl_department" value="{{ old('ssl_department') }}">
                                                <div id="department_error_block" class="text-danger"></div>
                                            </div>
                                            <div class="form-holder p10">
                                                <label for="ssl_city">{{ __('main.city') }}:</label>
                                                <input type="text" name="ssl_city" id="ssl_city" value="{{ old('ssl_city') }}">
                                                <div id="city_error_block" class="text-danger"></div>
                                            </div>
                                            <div class="form-holder p10">
                                                <label for="ssl_region">{{ __('main.region') }}:</label>
                                                <input type="text" name="ssl_region" id="ssl_region" value="{{ old('ssl_region') }}">
                                                <div id="region_error_block" class="text-danger"></div>
                                            </div>
                                            <div class="form-holder p10">
                                                <div class="select-holder">
                                                    <label for="ssl_country">{{ __('main.country') }}:</label>
                                                    <select name="ssl_country" id="ssl_country" value="{{ old('ssl_country') }}">
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div id="country_error_block" class="text-danger"></div>
                                            </div>
                                            <div class="form-holder p10">
                                                <label for="ssl_email">{{ __('main.email_address') }}:</label>
                                                <input type="text" name="ssl_email" id="ssl_email" value="{{ old('ssl_email') }}">
                                                <div id="email_error_block" class="text-danger"></div>
                                            </div>

                                            <a href="javascript:void(0)" id="csr_generate_button" class="btn-t1 margin-t full-width center">{{ __('main.generate_csr') }}<span class="fa fa-plus"></span></a>
                                        </div>

                                        <div class="form-holder p10" id="csr_code_form_holder" style="display: {{ !empty(old('csr_code')) ? 'block' : 'none' }};">
                                            <label for="csr_code">{{ __('main.enter_csr_code') }}:</label>
                                            <textarea name="csr_code" id="csr_code" cols="30" rows="10" style="font-family: monospace !important;">{{ old('csr_code') }}</textarea>
                                            <div style="display: block;" id="csr-message-holder"></div>
                                            <button type="button" id="copy_csr_code" class="btn-t1 margin-t">{{ __('main.copy_csr_code') }} <span class="fa fa-copy"></span></button>
                                        </div>

                                        <div class="form-holder p10" id="csr_private_key_holder" style="display:  {{ !empty(old('csr_code')) && old('radio-csr-choice') === 'auto' ? 'block' : 'none' }};">
                                            <label for="csr_private_key">{{ __('main.csr_private_key') }}:</label>
                                            <textarea name="csr_private_key" id="csr_private_key" cols="30" rows="10" style="font-family: monospace !important;">{{ old('csr_private_key') }}</textarea>
                                            <button type="button" id="copy_csr_private_key" class="btn-t1 margin-t">{{ __('main.copy_csr_private_key') }} <span class="fa fa-copy"></span></button>
                                        </div>

                                        <div class="form-holder p10" id="ssl_agreed_holder" style="display:{{ !empty(old('csr_code')) && old('radio-csr-choice') === 'auto' ? 'block' : 'none' }}">
                                            <div class="checkbox left" data-checkbox="block">
                                                <input type="checkbox" class="checkbox-toggler" id="ssl_agreed" name="ssl_agreed">
                                                <label for="ssl_agreed" class="text-bold">{{ __('main.ssl_agreed') }}</label>
                                            </div>
                                            <div id="agreed_error_block" class="text-danger pl-1">
                                                @if($errors->has('ssl_agreed'))
                                                    @foreach($errors->get('ssl_agreed') as $error)
                                                        <p>{{ $error }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="vps-border-divider"></div>

                                <button type="submit" class="btn-t1 margin-t full-width center">{{ __('main.add_to_cart') }} <span class="fa fa-cart-arrow-down"></span></button>
                            </div>
                        </form>

                        <div class="col-lg-4 sticky">
                            <div class="sidebar-cart" data-cart="holder"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="blockMessage" style="display:none;">
        <h4>{{ __('main.request_processing') }}</h4> <br>
        <span class="fa fa-spinner fa-spin fa-3x"></span>
    </div>
@endsection

@section('scripts')
    <script>
        var _ssl_confirmation_emails_url = '{{ route('ssl.get-confirmation-emails') }}';
        var _csr_generate_url = '{{ route('ssl.generate-csr') }}';
    </script>
    <script src="{{ url('/assets/no_bower_components/jquery.blockUI.js') }}"></script>
    <script src="{{ url(mix('js/ssl-cart.js')) }}"></script>
@endsection