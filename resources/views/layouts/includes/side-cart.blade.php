<div class="title">
    {{ __('main.cart') }}
</div>
<!--OVAJ DEO KODA SE POJAVLJUJE KADA JE KORPA PRAZNA-->
@if(Cart::count() == 0)
    <div class="empty-cart" data-cart="empty">{{ __('main.cart_empty') }}</div>
@else
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
                            <span>{{ $additionalItem->name }} ({{ App\Models\Subproduct::find($additionalItem->id)->price_foreign }}&euro;) (x{{ $additionalItem->qty }})</span>
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
                <div class="item-price">{{ number_format($item->total, 2, '.', ',') }} {!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</div>
                <a href="javascript:void(0)" class="remove-item" data-cart="remove"><span class="fa fa-close"></span></a>
            </li>
        @endforeach
    </ul>
@endif
<div class="total-in-cart">
    {{ __('main.total') }}
    <span class="cart-total-price">{{ Cart::total(2) }} {!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</span>
</div>

@if(Cart::count() > 0)
    <a href="{{ route('purchase.index') }}" class="btn-t1 full-width center">{{ strtoupper(__('main.make_order')) }} <span class="fa fa-cart-arrow-down"></span></a>
@endif