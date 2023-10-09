<form action="{{ config('nestpay.nestpay_url') }}" id="nestpay_payment_form" method="post">
    <input type="hidden" name="currency" value="{{ config('nestpay.currency') }}">
    <input type="hidden" name="trantype" value="{{ config('nestpay.trantype') }}">
    <input type="hidden" name="okUrl" value="{{ $data['okUrl'] }}">
    <input type="hidden" name="failUrl" value="{{ $data['failUrl'] }}">
    <input type="hidden" name="amount" value="{{ $data['amount'] }}">
    <input type="hidden" name="oid" value="{{ $data['oid'] }}">
    <input type="hidden" name="clientid" value="{{ config('nestpay.clientid') }}">
    <input type="hidden" name="storetype" value="{{ config('nestpay.storetype') }}">
    <input type="hidden" name="lang" value="{{ config('nestpay.lang') }}">
    <input type="hidden" name="hashAlgorithm" value="{{ config('nestpay.hashAlgorithm') }}">
    <input type="hidden" name="rnd" value="{{ $data['rnd'] }}">
    <input type="hidden" name="encoding" value="{{ config('nestpay.encoding') }}">
    <input type="hidden" name="hash" value="{{ $data['hash'] }}">

    <input type="hidden" name="shopurl" value="{{ $data['shopUrl'] ?? '' }}">
    <input type="hidden" name="tel" value="{{ $data['tel'] ?? '' }}">
    <input type="hidden" name="email" value="{{ $data['email'] ?? '' }}">
    <input type="hidden" name="BillToName" value="{{ $data['name'] ?? '' }}">
    <input type="hidden" name="BillToStreet1" value="{{ $data['address'] ?? '' }}">
    <input type="hidden" name="BillToStreet2" value="{{ $data['address2'] ?? '' }}">
    <input type="hidden" name="BillToCity" value="{{ $data['city'] ?? '' }}">
    <input type="hidden" name="BillToCountry" value="{{ $data['country_code'] ?? '' }}">
    <input type="hidden" name="BillToStateProv" value="{{ $data['state'] ?? '' }}">
    <input type="hidden" name="BillToPostalCode" value="{{ $data['postal_code'] ?? '' }}">
    @foreach($data['items'] as $key => $item)
        @php
            $num = $key + 1;
        @endphp
        <input type="hidden" name="ItemNumber{{ $num }}" value="{{ $num }}">
        <input type="hidden" name="Qty{{ $num }}" value="{{ $item['qty'] ?? 1 }}">
        <input type="hidden" name="Desc{{ $num }}" value="{{ $item['desc'] ?? '' }}">
        <input type="hidden" name="Price{{ $num }}" value="{{ $item['price'] ?? null }}">
        <input type="hidden" name="Total{{ $num }}" value="{{ $item['total'] ?? null }}">
    @endforeach
</form>