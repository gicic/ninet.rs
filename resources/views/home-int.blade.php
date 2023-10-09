@extends('layouts.master')

@section('title')
    NiNet Company
@endsection

@section('content')
    <section class="homepage-slider-section">
        <div class="homepage-slider">
            @if(App::getLocale() === 'sr-Latn')
                <div>
                    <div class="container">
                        <div class="row flex-holder">
                            <div class="col-lg-8 col-xl-6">
                                <div class="text-top">
                                    <span class="line1"><span class="c-yellow">Pametan internet izbor</span></span><br>
                                    <span class="line3"><span>Vaši omiljeni TV kanali na jednom mestu, IPTV i Netflix</span></span><br>
                                </div>
                                <div class="offer">
                                    <div class="offer-items">
                                        <ul class="check-list yellow-icon">
                                            <li>Internet odmah</li>
                                            <li>Bez ugovorne obaveze</li>
                                            <li>Slobodan izbor TV operatera</li>
                                        </ul>
                                    </div>
                                </div>
                                <a href="{{ route('offer.fiber-internet') }}" class="btn-t1 margin-t">{{ __('main.find_out_more') }}<span class="fa fa-eye"></span></a>
                            </div>
                            <div class="col-lg-4 col-xl-6 hidden-bellow-lg">
                                <div class="image-holder">
                                    <img src="{{ url('/images/slider/ilustracija_5.png') }}" class="img-responsive" style="max-height: 412px" alt="Homepage slider image"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="internet-packages">
        <div class="container">

            <div class="section-title-t1">
                <h2><span class="three-lines left"></span>{{ App::getLocale() === 'sr-Latn' ? 'INTERNET PAKETI' : 'INTERNET PACKAGES' }}<span class="three-lines right"></span></h2>
            </div>

            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="row three-packages-list">
                        <div class="col-md-4 col-md-offset-2">
                            <div class="package">
                                <div class="package-effect"></div>
                                <div class="content">
                                    <div class="image-holder">
                                        <img src="{{ url('/assets/images/icon-p-wireless.png') }}" alt="Icon wireless"/>
                                    </div>
                                    <h3>
                                        <span>{!! $internetContent['wireless'][App::getLocale()]['title'] !!}</span>
                                    </h3>
                                    <p class="short">
                                        {!! $internetContent['wireless'][App::getLocale()]['content'] !!}
                                    </p>
                                    <a href="{{ route('offer.wireless-internet') }}" class="btn-t2 text-lowercase">{{ __('main.find_out_more') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="package">
                                <div class="package-effect"></div>
                                <div class="content">
                                    <div class="image-holder">
                                        <img src="{{ url('/assets/images/icon-p-optical.png') }}" alt="Icon optical"/>
                                    </div>
                                    <h3>
                                        <span>{!! $internetContent['fiber'][App::getLocale()]['title'] !!}</span>
                                    </h3>
                                    <p class="short">
                                        {!! $internetContent['fiber'][App::getLocale()]['title'] !!}
                                    </p>
                                    <a href="{{ route('offer.fiber-internet') }}" class="btn-t2 text-lowercase">{{ __('main.find_out_more') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

{{--    <section class="business-packages">--}}
{{--        <div class="container">--}}

            {{--            <div class="row four-packages-list">--}}
            {{--                </div>--}}
            {{--                <div class="col-sm-6 col-lg-3">--}}
            {{--                    <div class="package">--}}
            {{--                        <div class="package-effect"></div>--}}
            {{--                        <div class="content">--}}
            {{--                            <div class="image-holder">--}}
            {{--                                <img src="{{ url('/assets/images/icon-p-dedicated.png') }}" alt="Icon Dedicated serveri"/>--}}
            {{--                            </div>--}}
            {{--                            <h3>--}}
            {{--                                <span>Dedicated servers</span>--}}
            {{--                            </h3>--}}
            {{--                            <p class="short">--}}
            {{--                                {!! $packagesContent['dedicated'][App::getLocale()] !!}--}}
            {{--                            </p>--}}
            {{--                            <a href="{{ route('offer.servers-linux') }}" class="btn-t2 text-lowercase">{{ __('main.find_out_more') }}</a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
{{--        </div>--}}

{{--    </section>--}}

    <section class="why-us">
        <div class="container">

            <div class="section-title-t1">
                <h2 class="c-yellow"><span class="three-lines left"></span>{{ App::getLocale() === 'sr-Latn' ? 'Zašto NiNet' : 'Why NiNet' }}<span class="three-lines right"></span></h2>
            </div>

            <div class="row">

                <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <p class="why-us-short">
                        {!! $whyNinet[App::getLocale()] !!}
                    </p>
                </div>

                <div class="col-md-3">
                    <div class="why-us-item">
                        <div class="icon-holder">
                            <img src="{{ url('/assets/images/icon-anchor.png') }}" alt="Icon anchor"/>
                        </div>
                        <p>{!! $iconsText['anchor'][App::getLocale()] !!}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="why-us-item">
                        <div class="icon-holder">
                            <img src="{{ url('/assets/images/icon-wallet.png') }}" alt="Icon wallet"/>
                        </div>
                        <p>{!! $iconsText['wallet'][App::getLocale()] !!}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="why-us-item">
                        <div class="icon-holder">
                            <img src="{{ url('/assets/images/icon-atom.png') }}" alt="Icon atom"/>
                        </div>
                        <p>{!! $iconsText['atom'][App::getLocale()] !!}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="why-us-item">
                        <div class="icon-holder">
                            <img src="{{ url('/assets/images/icon-gears.png') }}" alt="Icon gears"/>
                        </div>
                        <p>{!! $iconsText['gears'][App::getLocale()] !!}</p>
                    </div>
                </div>

            </div>

            <div class="center">
                <a href="{{ route('page.about') }}" class="btn-t1 margin-t text-uppercase">{{ __('main.find_out_more') }} <span class="fa fa-anchor"></span></a>
            </div>

        </div>
    </section>

    {{--<section class="three-blocks-section">--}}
    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-4">--}}
    {{--<div class="three-blocks-item">--}}
    {{--<span class="icon icon-rocket"></span>--}}
    {{--<p>Duis posuere blandit orci sed tincidunt. Curabitur porttitor nisi ac nunc ornare, in fringilla nisl blandit.</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-md-4">--}}
    {{--<div class="three-blocks-item">--}}
    {{--<span class="icon icon-24h"></span>--}}
    {{--<p>Duis posuere blandit orci sed tincidunt. Curabitur porttitor nisi ac nunc ornare, in fringilla nisl blandit.</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-md-4">--}}
    {{--<div class="three-blocks-item no-border">--}}
    {{--<span class="icon icon-files"></span>--}}
    {{--<p>Duis posuere blandit orci sed tincidunt. Curabitur porttitor nisi ac nunc ornare, in fringilla nisl blandit.</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</section>--}}
{{--    @include('partials.brands-int')--}}

    <section class="business-packages">
        <div class="container">
        </div>
    </section>
@endsection