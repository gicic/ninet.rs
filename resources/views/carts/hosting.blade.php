@extends('layouts.master-dc')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@section('content')
    <section class="page-top-part">
        <div class="container">

            <div class="page-title-block">
                <ul class="buying-process-menu">
                    <li class="active text-uppercase"><a href="javascript:void(0)">{{ __('main.adding_product_to_cart') }} </a></li>
                </ul>
            </div>

        </div>
    </section>

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
                    {{--<li>--}}
                        {{--<a href="pk-ssl.html">--}}
                            {{--ssl sertifikati--}}
                        {{--</a>--}}
                    {{--</li>--}}
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="row">

                        <form action="{{ route('hosting.add-to-cart') }}" method="post">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="col-lg-8">

                                <div class="block-t1">
                                    <div class="block-title">
                                        {{ __('main.product_characteristics') }}
                                    </div>
                                    <div class="block-content">
                                        <ul class="hosting-characteristics">
                                            @foreach($product->productCharacteristics as $characteristic)
                                                <li><span>{{ $characteristic->name }}: {{ $characteristic->description }}</span></li>
                                            @endforeach

                                            @if(!empty($periods))
                                                <li>
                                                    <span>{{ __('main.number_of_' . ($product->productLine->code === 'mail-servers' ? 'months' : 'years') ) }}</span>
                                                    <div>
                                                        <div class="select-holder">
                                                            <select name="order_period" id="order_period">
                                                                @foreach($periods as $period)
                                                                    <option value="{{ $period->id }}">{{ $period->period_text }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div class="block-t1">
                                    <div class="block-title">
                                        {{ __('main.domain_availability_check') }}
                                    </div>
                                    <div class="block-content">
                                        <div class="hosting-domain-availability">
                                            <div class="radio-box hosting-domain-availability-radio" data-radio="block">
                                                <div>
                                                    <input type="radio" name="radio-domain-availability" value="newDomain" id="newDomain" checked>
                                                    <label class="active" for="newDomain">{{ __('main.registering_new_domain') }}</label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="radio-domain-availability" value="existingDomain" id="existingDomain">
                                                    <label for="existingDomain">{{ __('main.have_domain') }}</label>
                                                </div>
                                            </div>

                                            <div class="form-holder p10">
                                                <input type="text" placeholder="{{ __('main.enter_domain_name') }}" name="domain_sld" id="domain_sld"  {{ $errors->has('domain') ? 'autofocus' : '' }}>
                                                <div class="select-holder" id="domain_tld_holder">
                                                    <select name="domain_tld" id="domain_tld">
                                                        @foreach($domainExtensions as $domain)
                                                            <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{--<a href="javascript:void(0)" id="domain"><span class="fa fa-plus"></span></a>--}}
                                                <div style="display: block;" id="domain-message-holder" class="text-danger">
                                                    @if($errors->has('domain'))
                                                        @foreach($errors->get('domain') as $error)
                                                            <p>{{ $error }}</p>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(count($product->subproducts))
                                    <div class="block-t1">
                                        <div class="block-title">
                                            {{ __('main.additional_products') }}
                                        </div>
                                        <div class="block-content">
                                            <ul class="vps-additional-services">
                                                @foreach($product->subproducts as $subproduct)
                                                    @if($subproduct->public === 1 && $subproduct->active === 1)
                                                        <li>
                                                            <div class="left-block">
                                                                <span class="service-name">{{ $subproduct->name }}</span>
                                                            </div>
                                                            <div class="right-block">
                                                                <div class="counter-holder">
                                                                    <div class="counter">
                                                                        <input id="counter_{{ $subproduct->id }}" type="text" name="additional_services[{{ $subproduct->code }}]" value="0" data-cart-additional-id="{{ $subproduct->id }}" readonly="readonly">
                                                                        <div class="counter-trigger addQuantity" data-code="{{ $subproduct->code }}" data-base-price="{{ $subproduct->getPrice() }}" data-counter-step="1" data-counter-max="{{ $subproduct->quantity_to }}" data-counter-type="add" data-counter-field="#counter_{{ $subproduct->id }}" data-price-field="#price_{{ $subproduct->id }}">+</div>
                                                                        <div class="counter-trigger minusQuantity" data-code="{{ $subproduct->code }}" data-base-price="{{ $subproduct->getPrice() }}" data-counter-step="1" data-counter-min="0" data-counter-type="minus" data-counter-field="#counter_{{ $subproduct->id }}" data-price-field="#price_{{ $subproduct->id }}">-</div>
                                                                    </div>
                                                                </div>
                                                                <div class="price-cart-holder">
                                                                    <span class="price"><span class="price-amount" id="price_{{ $subproduct->id }}">{{ $subproduct->getPrice() }}</span> {!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

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
    <script src="{{ url('/assets/no_bower_components/jquery.blockUI.js') }}"></script>
    <script>
        var _additional_add_url  = '{{ route('cart.add-additional') }}';
    </script>
    <script src="{{ url(mix('/js/counters.js')) }}"></script>
@endsection