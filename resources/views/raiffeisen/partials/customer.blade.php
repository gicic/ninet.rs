<table class="table table-condensed">
    <thead>
    <tr>
        <th colspan="2" class="text-uppercase">{{ __('main.customer_data') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-bold">{{ __('main.name_last_name') }}:</td>
        <td>{{ $customer['first_name'] . ' ' . $customer['last_name']}}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.address') }}:</td>
        <td>{{ $customer['address'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.city') }}:</td>
        <td>{{ $customer['city'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.postal_code') }}:</td>
        <td>{{ $customer['postal_code'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.country') }}:</td>
        <td>{{ $customer['country']->name }}</td>
    </tr>
    @if(isset($customer['state']))
        <tr>
            <td class="text-bold">{{ __('main.state') }}:</td>
            <td>{{ $customer['state'] }}</td>
        </tr>
    @endif
    <tr>
        <td class="text-bold">{{ __('main.email_address') }}:</td>
        <td>{{ $customer['email'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.contact_phone') }}:</td>
        <td>{{ $customer['phone'] }}</td>
    </tr>
    </tbody>
</table>