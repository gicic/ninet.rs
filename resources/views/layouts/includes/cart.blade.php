<a href="" class="cart-link cart-preview" data-drop="trigger">
    <span class="text cart-total-price">
        <span class="cart-price-price">{{ Cart::total() }}</span>
        <span class="cart-price-currency">{!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</span>
    </span>
    <span class="fa fa-cart-arrow-down"></span>
</a>
<div class="c-drop-content shop-cart-products" data-drop="content">

    <div class="cart-items-scroller">
        @if(Cart::count())
            <ul class="cart-items-list" data-cart="list">
                @foreach(Cart::mainItems() as $item)
                    <li data-cart="item" data-cart-id="{{ $item->rowId }}">
                        <h3 class="item-name">
                            <span>{{ $item->name }}</span>
                        </h3>
                        <div class="additional-options">
                            @foreach(Cart::additionalItems($item->rowId) as $additionalItem)
                                <div class="additional-item" data-cart-additional-item-id="{{ $additionalItem->rowId }}">
                                    <a href="javascript:void(0)" class="remove-additional-item" data-cart-additional="remove"><span class="fa fa-close"></span></a>
                                    <span class="additional-item-name">{{ $additionalItem->name }} (x{{ $additionalItem->qty }})</span>
                                    <span class="additional-item-price">{{ number_format($additionalItem->total, 2, '.', ',') }} {!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</span>
                                </div>
                            @endforeach
                            @if(!empty($item->options['domain']))
                                <div>{{ __('main.domain') }}: {{ $item->options['domain'] }}</div>
                            @endif
                            @if(!empty($item->options['hostname']))
                                <div>Hostname: {{ $item->options['hostname'] }}</div>
                            @endif
                            @if(!empty($item->options['operating_system_name']))
                                <div>OS: {{ $item->options['operating_system_name'] }}</div>
                            @endif
                        </div>
                        <div class="item-duration">{{ __('main.period') }}: <span>{{ $item->period }}</span></div>
                        <div class="item-price">
                            <span class="item-price-price">{{ number_format($item->total, 2, '.', ',') }}</span>
                            <span class="item-price-currency">{!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</span>
                        </div>
                        <a href="javascript:void(0)" class="remove-item" data-cart="remove"><span class="fa fa-close"></span></a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-cart" data-cart="empty">{{ __('main.cart_empty') }}</div>
        @endif
    </div>

    <div class="buttons-holder">
        @if(Cart::count() > 0)
            <div class="go-on-btn">
                <a href="{{ route('purchase.index') }}">{{ __('main.make_order') }}</a>
            </div>
        @endif
    </div>
</div>