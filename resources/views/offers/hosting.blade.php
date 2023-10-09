@extends('layouts.offer')

@section('page-title')
    {!! $offer->titleHtml !!}
@endsection

@section('page-description')
{{--    {!! $offer->description !!}}--}}
@endsection
{{--{{ dd(Cart::content()) }}--}}
@section('product-content')
    <section class="hosting-packages">
        <div class="container">

            <div class="tab-t1-holder">
                <!-- Nav tabs -->
                <ul class="c-tab tab-t1" role="tablist">
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane"  id="vps-tab1">
                        <div class="row four-packages-list">
                            @if(isset($offer->items))
                                @foreach($offer->items as $key => $item)
                                    <div class="col-md-{{ $offer->colspan['span'] }} {{ $key == 0 ? 'offset-md-' . $offer->colspan['offset'] : '' }}">
                                        @if($item->code === 'ssd-hosting-gold-pro')
                                            <center>
                                                <div class="card" style="background-color: #d4af37; width: 70%; margin-bottom:0rem !important;">
                                                    <div class="card-body fw-bold p-1" style="font-size: 20px; text-align: left">
                                                        <span class="text-success"><i class="fa fa-bolt"></i></span>&nbsp;LiteSpeed <br>
                                                        <span class="text-success"><i class="fa fa-shield"></i></span>&nbsp;ImunifyAV+
                                                    </div>
                                                </div>
                                            </center>
                                        @elseif($item->code === 'ssd-hosting-platinum-pro')
                                            <center>
                                                <div class="card" style="background-color: #e5e4e2; width: 70%; margin-bottom:0rem !important;">
                                                    <div class="card-body fw-bold p-1" style="font-size: 20px; text-align: left">
                                                        <span class="text-success"><i class="fa fa-bolt"></i></span>&nbsp;LiteSpeed <br>
                                                        <span class="text-success"><i class="fa fa-shield"></i></span>&nbsp;ImunifyAV+
                                                    </div>
                                                </div>
                                            </center>
                                        @else
                                            <div style="height: 94px"></div>
                                        @endif
                                        <div class="package">
                                            <div class="package-effect"></div>
                                            <div class="content">
                                                <div class="package-type">{{ ltrim($item->name) }}</div>
                                                <div class="package-price" style="font-size: {{ App::getLocale() === 'sr-Latn' ? '2.3rem' : '2.8rem'}}">
                                                    <span style="line-break: normal; width: 100% !important;">{{ number_format($item->getPrice(), 0, '.', ' ') }}<i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.8rem' : '2.8rem'}}">{!! App::getLocale() === 'sr-Latn' ? ' RSD' : '&euro;' !!}</i><i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.0rem'}}"> / {{ $offer->billingType }}</i></span>
                                                </div>

                                                @php
                                                    $mainCharacteristics = $item->productCharacteristics->take(5);
                                                    $additionalCharacteristics = $item->productCharacteristics->slice(5);
                                                @endphp

                                                <ul class="check-list">
                                                    @foreach($mainCharacteristics as $characteristic)
                                                        <li>{!! $characteristic->name !!}  <span class="fw-bold">{!! $characteristic->description !!}</span></li>
                                                    @endforeach
                                                    @if(count($additionalCharacteristics))
                                                        <li>
                                                            <div class="additional-holder">
                                                                <span class="additional-trigger">{{ __('main.additional_characteristics') }}</span>
                                                                <div class="additional-content">
                                                                    <h4 class="additional-title">{{ __('main.additional_characteristics') }}</h4>
                                                                    <ul>
                                                                        @foreach($additionalCharacteristics as $characteristic)
                                                                            @if($characteristic->description === 'NE' || $characteristic->description === 'NO')
                                                                                <span class=""><i class="fa fa-window-close"></i></span>&nbsp;{!! $characteristic->name !!}<br>
                                                                            @elseif($characteristic->description === 'DA' || $characteristic->description === 'YES')
                                                                                <li>{!! $characteristic->name !!}</li>
                                                                            @else
                                                                                <li>{!! $characteristic->name !!}  <span class="fw-bold">{!! $characteristic->description !!}</span></li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>

                                                <a href="{{ route('cart.hosting', ['productId' => Hashids::encode($item->id)]) }}" class="btn-t1 margin-t">{{ __('main.add_to_cart') }}<span class="fa fa-cart-arrow-down"></span>

                                                </a>
{{--                                                <div style="margin-top: 10px">--}}
{{--                                                    <h6>{{ App::getLocale() === 'sr-Latn' ? 'Samo za postojeće korisnike' : 'Only for existing customers' }}</h6>--}}
{{--                                                </div>--}}
{{--                                                 <a href="https://webglobe.rs/" class="add-to-wishlist">{{ App::getLocale() === 'sr-Latn' ? 'Ukoliko želite da postanete novi korisnik kliknite OVDE' : 'If you want to become a new customer click HERE' }}</a>--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection