<header id="header">
    <section class="h-top">
        <div class="container">
            <div class="left">
                <div class="phone">
                    <span class="fa fa-headphones icon"></span>{{ __('company.webglobe_phone') }}
                    <a href="mailto:helpdesk@webglobe.rs" target="_blank"><span class="fa fa-envelope-o icon" style="margin-left: 5px"></span><span class="text">helpdesk@webglobe.rs</span></a>
                </div>
            </div>
            <div class="right">

                {{-- Language picker --}}
                @include('layouts.includes.language-menu')
                {{-- / Language picker --}}

                <div class="user-menu" data-drop="holder">
                    <a href="https://cp.ninet.rs" target="_blank" class="user-menu-trigger"><span class="fa fa-heart icon"></span><span class="text">{{ __('main.my_webglobe') }}</span></a>
                </div>
                <div>
                    <a href="https://webmail.medianis.net" target="_blank" rel="nofollow"><span class="fa fa-envelope-o icon"></span><span class="text">WEB mail Medianis</span></a>
                </div>
            </div>
        </div>
    </section>
    <section class="h-middle">
        <div class="container">
            {{--            <div class="left">--}}
            {{--                <a href="{{ route('home') }}" class="logo-holder">--}}
            {{--                    <img src="{{ url('assets/images/webglobe-logo.png') }}" alt="Webglobe logo"/>--}}
            {{--                </a>--}}
            {{--            </div>--}}
            <div class="right">
                <nav>
                    <ul>
                        <li>
                            <a href="https://ninet.atlassian.net/wiki/spaces" target="_blank">{{ __('main.knowledge_base') }}</a>
                        </li>
                        <li>
                            @if(App::getLocale() === 'sr-Latn')
                                <a data-toggle="modal" data-target="#exampleModalOnama">{{ __('main.about_us') }}</a>
                            @else
                                <a data-toggle="modal" data-target="#exampleModalOnama">{{ __('main.about_us') }}</a>
                            @endif
                        </li>
                        <li>
                            @if(App::getLocale() === 'sr-Latn')
                                <a data-toggle="modal" data-target="#exampleModalContact">{{ __('main.contact') }}</a>
                            @else
                                <a data-toggle="modal" data-target="#exampleModalContact">{{ __('main.contact') }}</a>
                            @endif
                        </li>
                    </ul>
                </nav>
                <div class="ticket-create-holder">
                    <a href="https://www.ninet.rs/support/" class="ticket-create-link"><span class="text">{{ __('main.create_ticket') }} </span><span class="fa fa-hdd-o"></span></a>
                </div>

                <div class="cart-holder" data-drop="holder"></div>

                <a class="main-menu-trigger"><span></span></a>
            </div>
        </div>
    </section>
    <section class="h-bottom">
        <div class="container">
            @include('layouts.includes.navigation-dc')
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
    <!-- Modal / Kontakt-->
    <div class="modal fade" id="exampleModalContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <a href="https://www.webglobe.rs/kontakt" type="button" class="btn btn-success"><span class="continue">{{ 'Nastavi' }}</span></a>
                            @else
                                <a href="https://www.webglobe.com/contact" type="button" class="btn btn-success"><span class="continue">{{ 'Continue' }}</span></a>
                            @endif
                        </center>
                    </div>
                </center>
            </div>
        </div>
    </div>
</header>