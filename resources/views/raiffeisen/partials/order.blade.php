<table class="table table-condensed">
    <thead>
    <tr>
        <th colspan="2" class="text-uppercase">{{ __('main.order_data') }}</th>
    </tr>
    <tr>
        <th>{{ __('main.product') }}</th>
        <th>{{ __('main.unit_price') }}</th>
        <th>{{ __('main.quantity') }}</th>
        <th>{{ __('main.period_months') }}</th>
        <th>{{ __('main.tax_base') }}</th>
        <th>{{ __('main.tax_amount') }}</th>
        <th>{{ __('main.total') }}</th>
    </tr>
    </thead>
    <tbody>
    @if( ! empty($order->orderDetails))
        @foreach($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->description }}</td>
                <td>{{ number_format($detail->getBoundModel()->price_resident, 2) }} RSD</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ $detail->period_months }}</td>
                <td>{{ number_format($detail->taxBase(), 2) }} RSD</td>
                <td>{{ number_format($detail->taxAmount(), 2) }} RSD</td>
                <td>{{ number_format($detail->totalPrice() , 2)}} RSD</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5"></td>
            <td class="text-bold">{{ strtoupper(__('main.total')) }}:</td>
            <td class="text-bold">{{ number_format($order->totalPrice(), 2) }} RSD</td>
        </tr>
    @endif
    </tbody>
</table>