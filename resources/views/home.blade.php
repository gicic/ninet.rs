@extends('layouts.master-home')

@section('title')
    NiNet Company
@endsection

@section('content')

    <style>
        .internet-div{
            background-image: url('images/1445466.jpg');
            opacity: 80%;
        }
        .dc-div{
            background-image: url('images/servers.jpg');
            opacity: 80%;
        }

        .btn-t2 {
            display: inline-block;
            font-size: 1.2rem;
            font-weight: 1000;
            line-height: 29px !important;
            padding: 15px 25px !important;
            cursor: pointer;
        }

        .short{
            font-weight: 600 !important;
            font-size: 1rem !important;
        }
        @media only screen and (min-width: 600px) {
            .dc-div{
                height: 950px;
            }
            .internet-div{
                height: 950px;
            }
        }

        @media only screen and (max-width: 600px) {
            .dc-div{
                height: 450px;
            }
            .internet-div{
                height: 450px;
            }
        }
    </style>
    <section >
        <div class="row">
            <div class="col-md-6 internet-div">
                <div style="padding: 5px">
                    @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <img src="{{ url('/images/flags/' . $properties['flag']) }}" alt="" width="25px"> {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 offset-lg-1">
                            <div class="row three-packages-list">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="package" style="background-color: #cdcdcd; opacity: 80%; margin-top: 18%">
                                        <div class="package-effect"></div>
                                        <div class="content">
                                            <div class="image-holder">
                                                <img src="{{ url('/assets/images/icon-p-wireless.png') }}" alt="Icon wireless"/>
                                            </div>
                                            <h3>
                                                <span>{{ App::getLocale() === 'sr-Latn' ? 'INTERNET USLUGE' : 'INTERNET SERVICES' }}</span>
                                            </h3>
                                            <p class="short">
                                                (Wi-Fi, Fiber)
                                            </p>
                                            <a href="{{ route('home-int') }}" class="btn-t2 ">
                                                {{ App::getLocale() === 'sr-Latn' ? 'KLIKNI OVDE' : 'CLICK HERE' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 dc-div">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 offset-lg-1">
                            <div class="row three-packages-list">
                                <div class="col-md-8">
                                    <div class="package" style="background-color: #cdcdcd; opacity: 80%; margin-top: 25%">
                                        <div class="package-effect"></div>
                                        <div class="content">
                                            <div class="image-holder">
                                                <img src="{{ url('/assets/images/icon-p-ssl.png') }}" alt="Icon optical"/>
                                            </div>
                                            <h3>
                                                <span>{{ App::getLocale() === 'sr-Latn' ? 'DC USLUGE' : 'DC SERVICES' }}</span>
                                            </h3>
                                            <p class="short">
                                                {{ App::getLocale() === 'sr-Latn' ? '(Hosting, domeni, serveri, SSL)' : '(Hostings, domains, servers, SSL)' }}<br>
                                                {{ App::getLocale() === 'sr-Latn' ? 'Data center operations by Webglobe' : 'Data center operations by Webglobe' }}
                                            </p>
                                            <a href="{{ route('home-dc') }}" class="btn-t2">
                                                {{ App::getLocale() === 'sr-Latn' ? 'KLIKNI OVDE' : 'CLICK HERE' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection