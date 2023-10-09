<table>
    <thead>
    <tr>
        <th>{{ __('main.product') }}</th>
        <th>{{ __('main.price') }}</th>
        <th>{{ __('main.discount') }} %</th>
        <th>{{ __('main.unit_price') }}</th>
        <th>{{ __('main.accounting_period') }}</th>
    </tr>
    </thead>
    <tbody>

    @php
        $currency = App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;';
    @endphp
    @foreach(Cart::mainItems() as $item)
        @php $itemTotalPrice = $item->total; @endphp
        <tr>
            <td data-field-name="Proizvod">
                <div class="text2">
                    <span class="text-bold">{{ $item->name }}</span>  {{ $item->total }} {!! $currency !!}
                </div>
                @foreach(Cart::additionalItems($item->rowId) as $additionalItem)
                    @php $itemTotalPrice += $additionalItem->total; @endphp
                    <div class="additional-item ml-1" data-cart-additional-item-id="{{ $additionalItem->rowId }}">
                        <span>{{ $additionalItem->name }} (x{{ $additionalItem->qty }})</span>
                        <span class="additional-item-price">{{ $additionalItem->total }} {!! $currency !!}</span>
                    </div>
                @endforeach
            </td>
            <td data-field-name="Cena" class="price"><div><span>{{ $itemTotalPrice }}{!! $currency !!}</span></div></td>
            <td data-field-name="Popust %">{{ $item->discountPercentage }}<span></span></td>
            <td data-field-name="Jedinična Cena" class="price" data-cart-item-price="{{ $item->rowId }}"><div><span>{{ $item->price }}{!! $currency !!}</span></div></td>
            <td data-field-name="Period Obračuna"><span>{{ $item->period }} {{ $item->periodFullText }}</span></td>
        </tr>
    @endforeach

    <tr class="total">
        <td colspan="4">
            {{ __('main.total_for_payment') }}
        </td>
        <td class="total-price">
            <span class="total-price-price">{{ Cart::total() }}</span> <span class="total-price-currency">{!! $currency !!}</span>
        </td>
        <td colspan="2"></td>
    </tr>
    </tbody>
</table>