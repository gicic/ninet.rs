<div id="navigation">
    <nav>
        <div class="close-holder">
            <span class="fa fa-close"></span>
        </div>
        <ul>
            <li class="{{ Route::is('offer.wireless-internet') ? 'active' : '' }}">
                <a href="{{ route('offer.wireless-internet') }}">{{ App::getLocale() === 'sr-Latn' ? 'Bežični internet' : 'Wireless Internet' }}</a>
            </li>
            <li class="{{ Route::is('offer.fiber-internet') ? 'active' : '' }}">
                <a href="{{ route('offer.fiber-internet') }}">{{ App::getLocale() === 'sr-Latn' ? 'Optički internet' : 'Fiber Internet' }}</a>
            </li>
        {{--<li class="submenu-holder {{ Route::is('internet*') ? ' active' : '' }}" data-drop="holder">--}}
        {{--<a class="submenu-trigger" href="#" data-drop="trigger" >Internet <span class="fa fa-caret-down"></span></a>--}}
        {{--<ul class="submenu" data-drop="content">--}}
        {{--<li><a href="internet-opticki.php">Optički internet</a></li>--}}
        {{--<li><a href="internet-wireless.php">Wireless internet</a></li>--}}
        {{--<li><a href="internet-poslovni.php">Poslovni internet</a></li>--}}
        {{--<li><a href="net-cam.php">NET_CAM</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        <!--ovaj deo ispod se ne prikazuje na desktopu-->
            <li>
                <a href="#">{{ __('main.support') }}</a>
            </li>
            <li>
                <a href="{{ route('page.about') }}">{{ __('main.about_us') }}</a>
            </li>
            <li>
                <a href="{{ route('page.news') }}">{{ __('main.news') }}</a>
            </li>
            <li>
                <a href="{{ route('page.contact') }}">{{ __('main.contact') }}</a>
            </li>
        </ul>
    </nav>
</div>