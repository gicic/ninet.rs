<header id="header">
    <section class="h-top">
        <div class="container">
            <div class="left">
                <div class="phone">
                    <span class="fa fa-headphones icon"></span>{{ __('company.phone_1') }}, <span class="second-line">{{ __('company.phone_2') }}</span>
                </div>
            </div>
            <div class="right">

                {{-- Language picker --}}
                @include('layouts.includes.language-menu')
                {{-- / Language picker --}}

{{--                <div class="user-menu" data-drop="holder">--}}
{{--                    <a href="https://cp.ninet.rs" target="_blank" class="user-menu-trigger"><span class="fa fa-heart icon"></span><span class="text">{{ __('main.my_ninet') }}</span></a>--}}
{{--                </div>--}}
                <div>
                    <a href="mailto:support@ninet.rs" target="_blank" rel="nofollow"><span class="fa fa-envelope-o icon"></span><span class="text">support@ninet.rs</span></a>
                </div>
{{--                <div>--}}
{{--                    <a href="https://webmail.medianis.net" target="_blank" rel="nofollow"><span class="fa fa-envelope-o icon"></span><span class="text">WEB mail Medianis</span></a>--}}
{{--                </div>--}}
                <div class="search-menu" data-drop="holder">
                    <a href="#" data-drop="trigger" class="search-menu-trigger"><span class="fa fa-search icon"></span><span class="text">{{ __('main.search') }}</span></a>
                    <div data-drop="content" class="search-menu-content">
                        <form action="">
                            <div class="position-helper">
                                <div class="form-element type-2 no-margin">
                                    <input type="text" placeholder="{{ __('main.enter_term') }}">
                                </div>
                                <button><span class="fa fa-search"></span></button>
                            </div>
                        </form>
                    </div>c
                </div>
            </div>
        </div>
    </section>
    <section class="h-middle">
        <div class="container">
            <div class="left">
                <a href="{{ route('home-int') }}" class="logo-holder">
                    <img src="{{ url('assets/images/logo.png') }}" alt="Ninet logo"/>
                </a>
            </div>
            <div class="right">
                <nav>
                    <ul>
                        <li>
                            <a href="{{ route('page.support')}}">{{ __('main.support') }}</a>
                        </li>
{{--                        <li>--}}
{{--                            <a href="https://ninet.atlassian.net/wiki/spaces" target="_blank">{{ __('main.knowledge_base') }}</a>--}}
{{--                        </li>--}}
                        <li>
                            <a href="{{ route('page.about') }}">{{ __('main.about_us') }}</a>
                        </li>
{{--                        <li>--}}
{{--                            <a href="https://stories.ninet.rs/" target="_blank">Blog</a>--}}
{{--                        </li>--}}
                        <li>
                            <a href="{{ route('page.contact') }}">{{ __('main.contact') }}</a>
                        </li>
                    </ul>
                </nav>
{{--                <div class="ticket-create-holder">--}}
{{--                    <a href="https://www.ninet.rs/support/" class="ticket-create-link"><span class="text">{{ __('main.create_ticket') }} </span><span class="fa fa-hdd-o"></span></a>--}}
{{--                </div>--}}

{{--                <div class="cart-holder" data-drop="holder"></div>--}}

                <a class="main-menu-trigger"><span></span></a>
            </div>
        </div>
    </section>
    <section class="h-bottom">
        <div class="container">
            @include('layouts.includes.navigation')
        </div>
    </section>
</header>