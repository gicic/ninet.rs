<div class="language-menu" data-drop="holder">
    <a href="javascript:void(0)" data-drop="trigger" class="language-menu-trigger">
        <img class="center-block" src="{{ url('/images/flags/' . config('laravellocalization.supportedLocales.' . LaravelLocalization::getCurrentLocale() . '.flag')) }}" alt="{{ LaravelLocalization::getCurrentLocaleNative() }}" width="25px">
    </a>
    @if(Cart::count() == 0)
        <div data-drop="content" class="language-menu-content">
            <ul class="language-links-block">
                @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                    <li class="{{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'active' : '' }}">
                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <img src="{{ url('/images/flags/' . $properties['flag']) }}" alt="" width="25px"> {{ $properties['native'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
