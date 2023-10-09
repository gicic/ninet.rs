@extends('layouts.offer')

{{--{{ dd($offer) }}--}}

@section('page-title')
    {!! $offer->titleHtml !!}
@endsection

@section('page-description')
    {!! $offer->description !!}
@endsection
{{--{{ dd(Cart::content()) }}--}}
@section('product-content')
    <section class="hosting-packages">
        <div class="container">

            <div class="tab-t1-holder">
                <!-- Nav tabs -->
                <ul class="c-tab tab-t1" role="tablist">
                    <li>
{{--                        <a href="#vps-tab1" aria-controls="vps-tab1" role="tab" data-toggle="tab">--}}
{{--                            1 MESEC--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a href="#vps-tab2" aria-controls="vps-tab2" role="tab" data-toggle="tab">--}}
{{--                            10 + 2 MESECA--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane"  id="vps-tab1">
                        <div class="row four-packages-list">
                            @if(isset($offer->items))
                                @foreach($offer->items as $key => $item)
                                    <div class="col-md-{{ $offer->colspan['span'] }} {{ $key == 0 ? 'offset-md-' . $offer->colspan['offset'] : '' }}">
                                        <div class="package">
                                            <div class="package-effect"></div>
                                            <div class="content">
                                                <div class="package-type">{{ ltrim($item->name) }}</div>
                                                <div class="package-price" style="font-size: {{ App::getLocale() === 'sr-Latn' ? '2.3rem' : '2.8rem'}}">
                                                    <span style="line-break: normal; width: 100% !important;">{{ number_format($item->getPrice(), 0, '.', ' ') }}
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.8rem' : '2.8rem'}}">{!! App::getLocale() === 'sr-Latn' ? ' RSD' : '&euro;' !!}</i>
                                                        @if(!empty($offer->billingType))
                                                            <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.0rem'}}"> / {{ $offer->billingType }}</i>
                                                        @endif
                                                    </span>
                                                </div>

                                                @php
                                                $mainCharacteristics = $item->productCharacteristics->take(5);
                                                $additionalCharacteristics = $item->productCharacteristics->slice(5);
                                                @endphp

                                                <ul class="check-list">
                                                    @foreach($mainCharacteristics as $characteristic)
                                                        <li>{{ $characteristic->name }}  <span class="fw-bold {{ $characteristic->description === 'FREE' ? 'badge bg-success' : '' }}">{{ $characteristic->description }}</span></li>
                                                    @endforeach
                                                    @if(count($additionalCharacteristics))
                                                        <li>
                                                            <div class="additional-holder">
                                                                <span class="additional-trigger">{{ __('main.additional_characteristics') }}</span>
                                                                <div class="additional-content">
                                                                    <h4 class="additional-title">{{ __('main.additional_characteristics') }}</h4>
                                                                    <ul>
                                                                        @foreach($additionalCharacteristics as $characteristic)
                                                                            <li>{{ $characteristic->name }}  <span class="fw-bold">{{ $characteristic->description }}</span></li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>

                                                @if(is_null($item->available) || $item->available)
                                                    <a href="{{ route('cart.add', ['id' => Hashids::encode($item->id), 'cartRoute' => $offer->cartRoute]) }}" class="btn-t1 margin-t">{{ __('main.add_to_cart') }} <span class="fa fa-cart-arrow-down"></span></a>
{{--                                                    @if($item->productLine->code != 'server-housing')--}}
{{--                                                        <div style="margin-top: 10px">--}}
{{--                                                            <h6>{{ App::getLocale() === 'sr-Latn' ? 'Samo za postojeće korisnike' : 'Only for existing customers' }}</h6>--}}
{{--                                                        </div>--}}
{{--                                                        <a href="https://webglobe.rs/" class="add-to-wishlist">{{ App::getLocale() === 'sr-Latn' ? 'Ukoliko želite da postanete novi korisnik kliknite OVDE' : 'If you want to become a new customer click HERE' }}</a>--}}
{{--                                                    @endif--}}
                                                @else
                                                    <hr>
                                                    <span class="margin-t text-danger font-weight-bold text-lg-center">{{ __('main.unavailable_for_order') }}</span><br>
{{--                                                    <span class="margin-t text-danger font-weight-bold">{{ __('main.will_be_available_from') }}: <em>{{ isset($item->available_at) ? date('d.m.Y.', strtotime($item->available_at)) : '' }}</em></span>--}}
                                                    <a href="https://ninet.atlassian.net/servicedesk/" target="_blank">
                                                        <span class="margin-t text-danger font-weight-bold text-lg-center"><span class="text-primary">
                                                        <strong>{{App::getLocale() === 'sr-Latn' ? 'Kontaktirajte nas' : 'Contact us'}}</strong></span></span>
                                                    </a>
                                                    <strong>{{App::getLocale() === 'sr-Latn' ? 'za više informacija' : 'for more info'}}</strong>
                                                @endif
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