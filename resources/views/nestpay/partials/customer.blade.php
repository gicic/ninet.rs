<table class="table table-condensed">
    <thead>
    <tr>
        <th colspan="2" class="text-uppercase">{{ __('main.customer_data') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-bold">{{ __('main.name_last_name') }}:</td>
        <td>{{ $payment['name'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.address') }}:</td>
        <td>{{ $payment['address'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.city') }}:</td>
        <td>{{ $payment['city'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.postal_code') }}:</td>
        <td>{{ $payment['postal_code'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.country') }}:</td>
        <td>{{ $payment['country']->name }}</td>
    </tr>
    @if(isset($payment['state']))
        <tr>
            <td class="text-bold">{{ __('main.state') }}:</td>
            <td>{{ $payment['state'] }}</td>
        </tr>
    @endif
    <tr>
        <td class="text-bold">{{ __('main.email_address') }}:</td>
        <td>{{ $payment['email'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.contact_phone') }}:</td>
        <td>{{ $payment['phone'] }}</td>
    </tr>
    </tbody>
</table>