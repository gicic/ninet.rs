@component('mail::message')

    # {{ $title }}

    @component('mail::table')

        **{{ __('main.order') }}**

        |{{ __('main.product') }}|{{ __('main.unit_price') }}|{{ __('main.quantity') }}|{{ __('main.period_months') }}|{{ __('main.tax_base') }}|{{ __('main.tax_amount') }}|{{ __('main.total') }}|
        @if( ! empty($order->orderDetails))
            |-----------|:-----------:|:-----------:|:-----------:|:-----------:|:-----------:|:-----------:|
            @foreach($order->orderDetails as $detail)
                |{{ $detail->description }}|{{ number_format($detail->getBoundModel()->price_resident, 2) }} RSD|{{ $detail->quantity }}|{{ $detail->period_months }}|{{ number_format($detail->taxBase(), 2) }} RSD|{{ number_format($detail->taxAmount(), 2) }} RSD|{{ number_format($detail->totalPrice() , 2)}} RSD|
            @endforeach
            | | | | | |**{{ strtoupper(__('main.total')) }}:**|**{{ number_format($order->totalPrice(), 2) }} RSD**|
        @endif
    @endcomponent

    **{{ __('main.buyer') }}**

    {{ __('main.name_last_name') }}: {{ $contact['first_name'] . $contact['last_name']}} <br>
    {{ __('main.address') }}: {{ $contact['address'] }} <br>
    {{ __('main.city') }}: {{ $contact['city'] }} <br>
    {{ __('main.postal_code') }}: {{ $contact['postal_code'] }} <br>
    {{ __('main.country') }}: {{ $contact['country']->name }} <br>
    {{ __('main.contact_phone') }}: {{ $contact['phone'] }} <br>
    {{ __('main.email_address') }}: {{ $contact['email'] }} <br>

    **{{ __('main.seller') }}**

    {{ __('main.name') }}: {{ __('company.webglobe') }} <br>
    {{ __('main.address') }}: {{ __('company.address') }} <br>
    {{ __('main.email_address') }}: <br>
    MBR: 21774065<br>
    PIB: 112944432<br>

    **{{ __('main.transaction') }}**

    {{ __('main.order_id') }}: {{ $data['order_id'] }} <br>
    {{ __('main.auth_code') }}: {{ $data['approval_code'] }} <br>
    {{ 'XID' }}: {{ $data['xid'] }} <br>
    {{ 'Rrn' }}: {{ $data['rrn'] }} <br>
    {{ 'Transaction code' }}: {{ $data['tran_code'] }} <br>

@endcomponent