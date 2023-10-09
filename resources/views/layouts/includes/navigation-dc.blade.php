<style>
    .navigation-text{
        color:white!important;
    }
</style>

<div id="navigation">
    <nav>
        <div class="close-holder">
            <span class="fa fa-close"></span>
        </div>
        <ul>
            <li class=" {{ Route::is('offer.domains') ? ' active' : '' }}">
                @if(App::getLocale() === 'sr-Latn')
                    <a class="navigation-text" data-toggle="modal" data-target="#exampleModalDomain">{{ __('main.domains') }}</a>
                @else
                    <a class="navigation-text" data-toggle="modal" data-target="#exampleModalDomain">{{ __('main.domains') }}</a>
                @endif
            </li>
            <li class=" {{ Route::is('offer.hosting-web') ? ' active' : '' }}">
                @if(App::getLocale() === 'sr-Latn')
                    <a class="navigation-text" data-toggle="modal" data-target="#exampleModalHosting">{{ 'Hosting' }}</a>
                @else
                    <a class="navigation-text" data-toggle="modal" data-target="#exampleModalHosting">{{ 'Hosting' }}</a>
                @endif
            </li>
            <li class=" {{ Route::is('offer.servers-linux') || Route::is('offer.servers-windows') || Route::is('offer.server-housing') ? 'active' : '' }}">
                @if(App::getLocale() === 'sr-Latn')
                    <a class="navigation-text" data-toggle="modal" data-target="#exampleModalServeri">{{ App::getLocale() === 'sr-Latn' ? 'Serveri' : 'Servers' }}</a>
                @else
                    <a class="navigation-text" data-toggle="modal" data-target="#exampleModalServeri">{{ App::getLocale() === 'sr-Latn' ? 'Serveri' : 'Servers' }}</a>
                @endif
            </li>
            <li class=" {{ Route::is('offer.vps-ssd') || Route::is('offer.vps-ssd-cpanel') || Route::is('offer.windows-vps-servers') ? 'active' : '' }}">
                @if(App::getLocale() === 'sr-Latn')
                    <a class="navigation-text" data-toggle="modal" data-target="#exampleModalVps">VPS</a>
                @else
                    <a class="navigation-text" data-toggle="modal" data-target="#exampleModalVps">VPS</a>
                @endif
            </li>

            <!--ovaj deo ispod se ne prikazuje na desktopu-->
            <li>
                <a href="#">{{ __('main.support') }}</a>
            </li>
            <li>
                @if(App::getLocale() === 'sr-Latn')
                    <a data-toggle="modal" data-target="#exampleModalOnama">{{ __('main.about_us') }}</a>
                @else
                    <a data-toggle="modal" data-target="#exampleModalOnama">{{ __('main.about_us') }}</a>
                @endif
            </li>
            <li>
                <a href="{{ route('page-dc.news') }}">{{ __('main.news') }}</a>
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
</div>


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
<!-- Modal / Domeni-->
<div class="modal fade" id="exampleModalDomain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <a href="https://www.webglobe.rs/domeni" type="button" class="btn btn-success"><span class="continue">{{ 'Nastavi' }}</span></a>
                        @else
                            <a href="https://www.webglobe.com/domains" type="button" class="btn btn-success"><span class="continue">{{ 'Continue' }}</span></a>
                        @endif
                    </center>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- Modal / Hosting-->
<div class="modal fade" id="exampleModalHosting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <a href="https://www.webglobe.rs/webhosting" type="button" class="btn btn-success"><span class="continue">{{ 'Nastavi' }}</span></a>
                        @else
                            <a href="https://www.webglobe.com/webhosting" type="button" class="btn btn-success"><span class="continue">{{ 'Continue' }}</span></a>
                        @endif
                    </center>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- Modal / Serveri-->
<div class="modal fade" id="exampleModalServeri" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <a href="https://www.webglobe.rs/serveri" type="button" class="btn btn-success"><span class="continue">{{ 'Nastavi' }}</span></a>
                        @else
                            <a href="https://www.webglobe.com/servers" type="button" class="btn btn-success"><span class="continue">{{ 'Continue' }}</span></a>
                        @endif
                    </center>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- Modal / Serveri-->
<div class="modal fade" id="exampleModalVps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <a href="https://www.webglobe.rs/serveri#virtuelni" type="button" class="btn btn-success"><span class="continue">{{ 'Nastavi' }}</span></a>
                        @else
                            <a href="https://www.webglobe.com/servers#virtual" type="button" class="btn btn-success"><span class="continue">{{ 'Continue' }}</span></a>
                        @endif
                    </center>
                </div>
            </center>
        </div>
    </div>
</div>