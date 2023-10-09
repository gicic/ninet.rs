@extends('layouts.master-payment')

@php
    $MerchantID =  $data_pay['MerchantID'];
    $TerminalID = $data_pay['TerminalID'];
    $CurrencyID = $data_pay['Currency'];
    $OrderID = $data_pay['OrderID'];
    $PurchaseTime = $data_pay['PurchaseTime'];
    $TotalAmount = (int)$data_pay['TotalAmount']  * 100;
    $delay = 0;
    $sd = 1856;
    $data= "$MerchantID;$TerminalID;$PurchaseTime;$OrderID,$delay;$CurrencyID;$TotalAmount;;";
    $fp = fopen("217740653135FFC.pem", "r");
    $priv_key = fread($fp, 8192);
    fclose($fp);
    $pkeyid = openssl_get_privatekey($priv_key);
    openssl_sign($data, $signature, $pkeyid);
    openssl_free_key($pkeyid);
    $b64sign = base64_encode($signature);

@endphp

<form action="{{ 'https://ecommerce.raiffeisenbank.rs/rbrs/enter'  }}" id="nestpay_payment_form" method="post">
    <input name="Version" type="hidden" value="1" />
    <input name="MerchantID" type="hidden" value="<?php echo $MerchantID ?>" />
    <input name="TerminalID" type="hidden" value="<?php echo $TerminalID ?>" />
    <input type="hidden" name="PurchaseTime" value="<?php echo $PurchaseTime ?>"/>
    <input type="hidden" id="order" name="OrderID" value="<?php echo $OrderID; ?>"/>
    <input type="hidden" id="delay" name="Delay" value="<?php echo $delay; ?>"/>
    <input name="Currency" type="hidden" value="<?php echo $CurrencyID ?>" />
    <input name="TotalAmount" type="hidden" value="<?php echo $TotalAmount; ?>"/>
    <input name="locale" type="hidden" value="rs" />
    <input name="PurchaseDesc" type="hidden" value="payment" />
    <input name="Signature" type="hidden" value="<?php echo "$b64sign" ?>"/>
</form>

@section('scripts')
    <script>
        $(function() {
            $("#nestpay_payment_form").submit(); // using ID
        });
    </script>
@endsection
