<table class="table table-condensed">
    <thead>
    <tr>
        <th colspan="2" class="text-uppercase">{{ __('main.transaction_data') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-bold">{{ __('main.order_id') }}</td>
        <td>{{ $payment['order_id'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.auth_code') }}</td>
        <td>{{ $payment['auth_code'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.payment_status') }}</td>
        <td>{{ $payment['response'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.transaction_status_code') }}</td>
        <td>{{ $payment['proc_return_code'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.transaction_id') }}</td>
        <td>{{ $payment['transaction_id'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.transaction_date') }}</td>
        <td>{{ $payment['transaction_date'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ __('main.md_status') }}</td>
        <td>{{ $payment['md_status'] }}</td>
    </tr>
    </tbody>
</table>