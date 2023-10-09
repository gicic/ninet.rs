<div class="block-t1">
    <div class="block-title">
        {{ __('main.additional_products') }}
    </div>
    <div class="block-content">
        <ul class="vps-additional-services">
            @foreach($product->subproducts()->where('public', 1)->where('active', 1)->get() as $subproduct)
                <li data-cart="item" data-cart-additional-for="" data-cart-id="{{ $cartItem->rowId }}" data-cart-data1="{{ $subproduct->name }}" data-cart-duration="" data-cart-price="{{ $subproduct->getPrice() }}">
                    <div class="left-block">
                        <span class="service-name">{{ $subproduct->name }}</span>
                    </div>
                    <div class="right-block">
                        <div class="counter-holder">
                            <div class="counter">
                                <input id="counter_{{ $subproduct->id }}" type="text" name="amount" value="{{ $subproduct->quantity_from }}" data-cart-additional-id="{{ $subproduct->id }}" readonly="readonly">
                                <div class="counter-trigger addQuantity" data-code="{{ $subproduct->code }}" data-base-price="{{ $subproduct->getPrice() }}" data-counter-step="1" data-counter-max="{{ $subproduct->quantity_to }}" data-counter-type="add" data-counter-field="#counter_{{ $subproduct->id }}" data-price-field="#price_{{ $subproduct->id }}">+</div>
                                <div class="counter-trigger minusQuantity" data-code="{{ $subproduct->code }}" data-base-price="{{ $subproduct->getPrice() }}" data-counter-step="1" data-counter-min="{{ $subproduct->quantity_from }}" data-counter-type="minus" data-counter-field="#counter_{{ $subproduct->id }}" data-price-field="#price_{{ $subproduct->id }}">-</div>
                            </div>
                        </div>
                        <div class="price-cart-holder">
                            <span class="price"><span class="price-amount" id="price_{{ $subproduct->id }}">{{ $subproduct->getPrice() }}</span> {!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</span>
                            <a class="add-to-cart" href="javascript:void(0)" data-cart-additional="trigger" data-additional-id="{{ $subproduct->id }}">{{ __('main.add_to_cart') }}</a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>