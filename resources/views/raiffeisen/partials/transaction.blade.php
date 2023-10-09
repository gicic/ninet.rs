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
        <td class="text-bold">{{ 'Approval code' }}</td>
        <td>{{ $payment['approval_code'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ 'Transaction codes' }}</td>
        <td>{{ $payment['tran_code'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ 'XID' }}</td>
        <td>{{ $payment['xid'] }}</td>
    </tr>
    <tr>
        <td class="text-bold">{{ 'Rrn' }}</td>
        <td>{{ $payment['rrn'] }}</td>
    </tr>
    </tbody>
</table>