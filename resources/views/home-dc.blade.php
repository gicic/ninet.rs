@extends('layouts.master-dc')

@section('title')
    Webglobe
@endsection

@section('content')
    <section class="homepage-slider-section">
        <div class="homepage-slider">
            <div>
                <div class="container">
                    <div class="row flex-holder">
                        <div class="col-lg-4 col-xl-6 hidden-bellow-lg">
                            <div class="image-holder">
                                <img src="{{ url('/images/slider/index.png') }}" class="img-responsive" style="max-height: 412px" alt="Homepage slider image"/>
                            </div>
                        </div>
                        <div class="col-lg-8 col-xl-6" style="margin-left: 99px">
                            <div class="text-top">
                                <span class="line1"><span class="c-yellow">{{ App::getLocale() === 'sr-Latn' ? 'NiNet Data Center ' : 'NiNet Data Center' }}</span></span><br>
                                <span class="line1"><span class="c-yellow">{{ App::getLocale() === 'sr-Latn' ? 'je postao deo kompanije Webglobe kako bismo Vam ponudili još bolje usluge.' : 'has become a part of Webglobe in order to provide you with better services.' }}</span></span><br><br><br>
                                {{--                                <span class="line2"><span>{{ App::getLocale() === 'sr-Latn' ? 'Tražite savršen domen?' : 'Searching for that perfect domain?' }}</span></span><br>--}}
                                {{--                                <span><span class="c-yellow slider-text-smaller">{{ App::getLocale() === 'sr-Latn' ? 'Pronađite domen koji ste oduvek želeli' : 'Get the domain name you always wanted.' }}</span></span>--}}
                            </div>
                            <button data-toggle="modal" data-target="#exampleModal" class="btn-t1 margin-t">{{ App::getLocale() === 'sr-Latn' ? 'Nastavite na Webglobe.rs ' : 'Continue to Webglobe.com' }}<span class="fa fa-eye"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="why-us">
        <div class="container">
            <div class="section-title-t1">
                <h2 class="c-yellow"><span class="three-lines left"></span>{{ App::getLocale() === 'sr-Latn' ? 'Zašto Webglobe' : 'Why Webglobe' }}<span class="three-lines right"></span></h2>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <p class="why-us-short">
                        {{--                        {!! $whyNinet[App::getLocale()] !!}--}}
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
                @if(App::getLocale() === 'sr-Latn')
                    <button data-toggle="modal" data-target="#exampleModalOnama" class="btn-t1 margin-t text-uppercase">{{ __('main.find_out_more') }} <span class="fa fa-anchor"></span></button>
                @else
                    <button data-toggle="modal" data-target="#exampleModalOnama" class="btn-t1 margin-t text-uppercase">{{ __('main.find_out_more') }} <span class="fa fa-anchor"></span></button>
                @endif
            </div>
        </div>
    </section>
    <style>
        .modal-content{
            background-color: black;
            color: white;
        }
        .continue{
            color: black;
        }
        .x{
            color: white!important;
        }
        .modal-header{
            border-bottom: none!important;
        }
        .modal-footer{
            border-top: none!important;
        }
    </style>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="x">&times;</span>
                    </button>
                </div>
                <center>
                    <div class="modal-body">
                        <h5 id="exampleModalLabel">{{ App::getLocale() === 'sr-Latn' ? 'NiNet Data Center je postao deo kompanije Webglobe kako bi Vam omogućio najbolje hosting iskustvo.' : 'NiNet Data Center has become a part of Webglobe in order to provide you with better services.' }}</h5>
                    </div>

                    <div class="modal-body">
                        <img src="{{ url('/images/slider/index.png') }}" class="img-responsive" style="max-height: 82px" alt="Homepage slider image"/>
                    </div>

                    <div class="modal-footer">
                        <center>
                            @if(App::getLocale() === 'sr-Latn')
                                <a href="https://www.webglobe.rs" type="button" class="btn btn-success"><span class="continue">{{ 'Nastavi' }}</span></a>
                            @else
                                <a href="https://www.webglobe.com" type="button" class="btn btn-success"><span class="continue">{{ 'Continue' }}</span></a>
                            @endif
                        </center>
                    </div>
                </center>
            </div>
        </div>
    </div>

    <!-- Modal / O nama-->
    <div class="modal fade" id="exampleModalOnama" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="x">&times;</span>
                    </button>
                </div>
                <center>
                    <div class="modal-body">
                        <h5 id="exampleModalLabel">{{ App::getLocale() === 'sr-Latn' ? 'NiNet Data Center je postao deo kompanije Webglobe kako bi Vam omogućio najbolje hosting iskustvo.' : 'NiNet Data Center has become a part of Webglobe in order to provide you with better services.' }}</h5>
                    </div>

                    <div class="modal-body">
                        <img src="{{ url('/images/slider/index.png') }}" class="img-responsive" style="max-height: 82px" alt="Homepage slider image"/>
                    </div>

                    <div class="modal-footer">
                        <center>
                            @if(App::getLocale() === 'sr-Latn')
                                <a href="https://www.webglobe.rs/o-nama" type="button" class="btn btn-success"><span class="continue">{{ 'Nastavi' }}</span></a>
                            @else
                                <a href="https://www.webglobe.com/about-us" type="button" class="btn btn-success"><span class="continue">{{ 'Continue' }}</span></a>
                            @endif
                        </center>
                    </div>
                </center>
            </div>
        </div>
    </div>
@endsection