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
                        <a href="javascript:void(0)">
                            {{ __('main.domains') }}
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="block-t1">
                                <div class="block-title">
                                    {{ __('main.you_chose') }}
                                </div>
                                <div class="block-content">
                                    <ul class="selected-domains">
                                        @foreach($cartDomains as $item)
                                            @php
                                                $product = App\Models\Product::with('subproducts')->find($item->id);
                                                $whois = $product->subproducts->whereIn('code', ['whois-cctld', 'whois-gtld'])->first();
                                                if(Cart::content()->contains('parentRowId', $item->rowId)) {
                                                    $cartWhois = Cart::additionalItems($item->rowId)->where('id', $whois->id)->first();
                                                }
                                            @endphp
                                            <li data-domain-row-id="{{ $item->rowId }}">
                                                <div class="col-xs-12 col-md-4">
                                                    <span>{{ $item->name }}</span>
                                                </div>
                                                <div class="col-xs-12 col-md-4">
                                                    <span>{{ __('main.number_of_years') }}</span>
                                                    <span>
                                                        <div class="form-element select-holder">
                                                            <select class="domain_order_period" data-cart-item-row-id="{{ $item->rowId }}" data-domain-name="{{ $item->name }}">
                                                                @foreach(range(1, 10) as $period)
                                                                    <option value="{{ $period }}" {{ $item->period == $period ? 'selected' : '' }}>{{ $period }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </span>
                                                </div>
                                                <div class="col-xs-12 col-md-4">
                                                    @if(isset($whois))
                                                        <span class="checkbox left" data-checkbox="block">
                                                        <input type="checkbox"
                                                               id="whois_{{ $loop->iteration }}"
                                                               name="whois_{{ $loop->iteration }}"
                                                               data-cart-additional-id="{{ $whois->id }}"
                                                               data-cart-item-id="{{ $item->rowId }}"
                                                               data-cart-row-id="{{ !empty($cartWhois->rowId) ? $cartWhois->rowId : '' }}" {{ !empty($cartWhois) ? 'checked' : '' }}>
                                                        <label class="{{ !empty($cartWhois) ? 'active' : '' }}" for="whois_{{ $loop->iteration }}">{{ __('main.whois_privacy') }} <span class="text-bold">{{ number_format($whois->price_foreign, 0) }} &euro;</span></label>
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="clearfix"></div>
                                            </li>
                                            @php
                                            $cartWhois = null;
                                            @endphp
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            {{--<div class="check-inputs-block">--}}
                                {{--<div class="pos-helper">--}}
                                    {{--<div class="form-element type-2 required dns1">--}}
                                        {{--<input type="text" placeholder="ns1.hostingweb.rs"/>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-element type-2 required dns1">--}}
                                        {{--<input type="text" placeholder="ns2.hostingweb.rs"/>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="block-t1">
                                <div class="block-title">
                                    {{ __('main.add_hosting_for_domain') }}
                                </div>
                                <div class="block-content">
                                    <div class="radio-box sh-radio" data-radio="block">
                                        @foreach($hosting->productLines()->where('code', '!=', 'mail-servers')->where('code', '!=', 'web-hosting')->get() as $line)
                                            <div>
                                                <input type="radio" name="hosting_lines" value="{{ $line->code }}" id="{{ $line->code }}" {{ $loop->iteration == 1 ? 'checked' : '' }}>
                                                <label class="{{ $loop->iteration == 1 ? 'active' : '' }}" for="{{ $line->code }}">{{ $line->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="sh-prices">
                                        <div class="row sh-prices-list">
                                            <div class="col-xs-12 col-md-4">
                                                {{ __('main.domain_for_hosting') }}:
                                                <div class="form-element select-holder">
                                                    <select name="main_domain" id="main_domain">
                                                        @foreach($cartDomains as $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <span>{{ __('main.number_of_years') }}</span>
                                                <span>
                                                    <div class="form-element select-holder">
                                                        <select class="hosting_order_period">
                                                            @foreach($hostingPeriods as $period)
                                                                <option value="{{ $period->id }}">{{ $period->period_text }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </span>
                                            </div>

                                            <div class="clearfix"></div>
                                            @foreach($hosting->productLines as $line)
                                                <div id="line_wrapper_{{ $line->code }}" style="display: {{ $loop->iteration == 2 ? 'block' : 'none' }}">
                                                    @foreach($line->products as $product)
                                                        @if($product->public === 1 && $product->active === 1)
                                                            <div class="col-sm-6 col-md-3">
                                                                <div class="sh-prices-item" data-cart="item" data-cart-id="y1" data-cart-data1="Basic" data-cart-data2="SSD" data-cart-duration="1 godina" data-cart-price="10">
                                                                    <div class="top-part">
                                                                        {{ $product->name }}
                                                                    </div>
                                                                    <div class="middle-part">
                                                                        <ul class="check-list">
                                                                            @foreach($product->productCharacteristics as $characteristic)
                                                                                <li>{{ $characteristic->name }}: <span class="fw-bold">{{ $characteristic->description }}</span></li>
                                                                            @endforeach
                                                                        </ul>
                                                                        <span class="price-yearly">{{ __('main.price_yearly') }}</span>
                                                                    </div>
                                                                    <div class="bottom-part">
                                                                        <span class="price">{{ number_format($product->price_foreign, 0) }} &euro;</span>
                                                                        <a class="add-to-cart add-hosting-to-cart" href="javascript:void(0)" data-cart-id="{{ $product->id }}" data-cart="trigger">{{ __('main.add_to_cart') }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('purchase.index') }}" class="btn-t1 margin-t full-width center">{{ __('main.make_order') }} <span class="fa fa-cart-arrow-down"></span></a>

                        </div>

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
        var _additional_add_url = '{{ route('cart.add-additional') }}';
        var _whois_remove_url = '{{ route('cart.remove-whois') }}';
    </script>
    <script src="{{ url(mix('js/domain-cart.js')) }}"></script>
@endsection