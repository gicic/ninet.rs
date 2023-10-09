@extends('layouts.offer-int')

@section('page-title')
  {!! $offer->titleHtml !!}
@endsection

@section('page-description')

    {!! $offer->description !!}
    @if(\App::getLocale() === 'sr-Latn' && $offer->title != 'Bežični internet' && $offer->title != 'Wireless internet')
        <h3 style="color: #FFC20E; font-weight: 600;"> Izaberi dodatni popust tokom trajanja akcije.</h3>
        <h5 style="color: #FFC20E; font-weight: 600;"><span class="fa fa-phone"></span> +381 65 941-00-00</h5>
    @endif
@endsection

@section('product-content')
    <section class="hosting-packages">
        <div class="container">

            <div class="tab-t1-holder">
                <!-- Nav tabs -->
                <ul class="c-tab tab-t1" role="tablist">
                    {{--<li>--}}
                    {{--<a href="#vps-tab1" aria-controls="vps-tab1" role="tab" data-toggle="tab">--}}
                    {{--1 MESEC--}}
                    {{--</a>--}}
                    {{--</li>--}}

                    {{--<li>--}}
                    {{--<a href="#vps-tab2" aria-controls="vps-tab2" role="tab" data-toggle="tab">--}}
                    {{--10 + 2 MESECA--}}
                    {{--</a>--}}
                    {{--</li>--}}
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
                                                @if ($offer->title == 'Bežični internet' || $offer->title == 'Wireless internet')
                                                <div class="package-type">{{ ltrim($item->naziv_proizvoda) }}</div>
                                                <div class="package-price" style="font-size: {{ App::getLocale() === 'sr-Latn' ? '2.3rem' : '2.8rem'}}">
                                                    <span style="line-break: normal; width: 100% !important;">{{ number_format(App::getLocale() === 'sr-Latn' ? $item->price : $item->cena_euro_pdv, 0, '.', ' ') }}<i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.8rem' : '2.8rem'}}">{!! App::getLocale() === 'sr-Latn' ? ' RSD' : '&euro;' !!}</i></span>

                                                    @else

                                                    <div class="package-price mt-0">{{ substr(ltrim($item->naziv_proizvoda), 0, 11) }}<br>{{ substr(ltrim($item->naziv_proizvoda), 12) }}</div>
                                                <div class="package-price mb-0" style="font-size: {{ App::getLocale() === 'sr-Latn' ? '2.3rem' : '2.8rem'}}">
                                                    <span style="line-break: normal; width: 100% !important;">{{ number_format(App::getLocale() === 'sr-Latn' ? ($key == 0 ? 1700 : ($key == 1 ? 1800 : 2200)) : $item->cena_euro_pdv, 0, '.', ' ') }}
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.8rem'}}">{!! App::getLocale() === 'sr-Latn' ? ' RSD' : '&euro;' !!}</i>
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.0rem'}}"> / mesečno</i>
                                                        <br>
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1rem' : '2.0rem'}}"> * za ugovor na 24 meseca</i><br>
                                                    </span>
                                                </div>
                                                <div class="package-price mb-0" style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.8rem'}}">
                                                    <span style="line-break: normal; width: 100% !important;">{{ number_format(App::getLocale() === 'sr-Latn' ? ($key == 0 ? 1800 : ($key == 1 ? 1900 : 2600)) : $item->cena_euro_pdv, 0, '.', ' ') }}
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.8rem'}}">{!! App::getLocale() === 'sr-Latn' ? ' RSD' : '&euro;' !!}</i>
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.0rem'}}"> / mesečno</i>
                                                        <br>
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1rem' : '2.0rem'}}"> * za ugovor na 12 meseci</i>
                                                        </span>
                                                </div>
                                                <div class="package-price mb-0" style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.8rem'}}">
                                                    <span style="line-break: normal; width: 100% !important;">{{ number_format(App::getLocale() === 'sr-Latn' ? ($key == 0 ? 1850 : ($key == 1 ? 2200 : 2800)) : $item->cena_euro_pdv, 0, '.', ' ') }}
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.8rem'}}">{!! App::getLocale() === 'sr-Latn' ? ' RSD' : '&euro;' !!}</i>
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1.3rem' : '2.0rem'}}"> / mesečno</i>
                                                        <br>
                                                        <i style="font-size: {{ App::getLocale() === 'sr-Latn' ? '1rem' : '2.0rem'}}"> * bez ugovorne obaveze</i>
                                                    </span>
                                                @endif
                                                </div>

                                                <a href="{{ route('internet.create', ['id' => $item->id_proizvodi]) }}" class="btn-t1 margin-t">{{ __('main.make_order') }} <span class="fa fa-cart-arrow-down"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if(\App::getLocale() === 'sr-Latn')
                <div class="col-xs-12 p-1" align="center">
                    <h6>
                        Uz ove pakete moguće je pretplatiti se na korišćenje statičke javne ip adrese uz uvećanje računa od samo 590 din. mesečno sa PDV-om. <br>
                        Dodatne povoljnosti za pakete uz ugovor na 12 i 24 meseci: <br>
                        Korisnik uz ugovor na 12 i 24 meseci dobija na korišćenje wireless ruter.
                    </h6>
                </div>
            @endif

            @if ($offer->title != 'Bežični internet' && $offer->title != 'Wireless internet')
                    <h6>Uz ugovor na 12 i 24 meseca instalacija i podešavanje su besplatani.<br>Bez ugovorne obaveze setup je 19.000 rsd uz mesečno plaćanje. Ukoliko se plati prvih 6 meseci unapred, setup je besplatan.</h6>
                </div>
            @endif

            <div class="col-xs-12 mt-3">
                <a href="{{ route('internet.terms') }}" target="_blank"><h6><i class="fa fa-file-pdf-o"></i> {{ __('main.terms_and_conditions') }}</h6></a>
            </div>
            <div class="col-xs-12">
                <a href="{{ route('internet.personality-data') }}" target="_blank"><h6><i class="fa fa-file-pdf-o"></i> Obrada podataka o ličnosti</h6></a>
            </div>
            <div class="col-xs-12">
                <a href="{{ route('internet.objection-resolve') }}" target="_blank"><h6><i class="fa fa-file-pdf-o"></i> Rešavanje prigovora</h6></a>
            </div>
        </div>
    </section>
@endsection