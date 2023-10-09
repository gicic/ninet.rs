
<?php
$MerchantID = $data['MerchantID'];
$TerminalID = $data['TerminalID'];
$OrderID = $data['OrderID'];
$Delay = $data['Delay'];
$PurchaseTime = $data['PurchaseTime'];
$TotalAmount = $data['TotalAmount'];
$AltTotalAmount = $data["AltTotalAmount"];
$CurrencyID = $data['Currency'];
$AltCurrencyID = $data['AltCurrency'];
$XID = $data['XID'];
$SD = $data['SD'];
$TranCode = $data['TranCode'];
$ApprovalCode = $data['ApprovalCode'];
$signature = $data["Signature"];

$signature = base64_decode($signature);

if($AltTotalAmount){
    $data = $MerchantID . ";" . $TerminalID . ";" . $PurchaseTime . ";" . $OrderID . "," . $Delay . ";" . $XID . ";" . $CurrencyID . "," . $AltCurrencyID . ";" . $TotalAmount . "," . $AltTotalAmount . ";" . $SD . ";" . $TranCode . ";" . $ApprovalCode.";";
}else{
    $data = $MerchantID . ";" . $TerminalID . ";" . $PurchaseTime . ";" . $OrderID . "," . $Delay . ";" . $XID . ";" . $CurrencyID . ";" . $TotalAmount . ";" . $SD . ";" . $TranCode . ";" . $ApprovalCode.";";
}

$crtid = openssl_pkey_get_public(file_get_contents('test-server.cert'));
$verify_status = openssl_verify($data, $signature, $crtid);

openssl_free_key($crtid);

if($verify_status == 1){
    echo "MerchantID = " . $MerchantID . "\n";
    echo "TerminalID = " . $TerminalID . "\n";
    echo "OrderID = " . $OrderID . "\n";
    echo "Delay = " . $Delay . "\n";
    echo "Currency = " . $CurrencyID . "\n";
    echo "TotalAmount = " . $TotalAmount . "\n";
    echo "XID = " . $XID . "\n";
    echo "PurchaseTime = " . $PurchaseTime . "\n";
    echo "Response.action= approve \n";
    echo "Response.reason= ok \n";
    echo "Response.forwardUrl=  \n";
}else{
    echo "MerchantID = " . $MerchantID . "\n";
    echo "TerminalID = " . $TerminalID . "\n";
    echo "OrderID = " . $OrderID . "\n";
    echo "Delay = " . $Delay . "\n";
    echo "Currency =  " . $CurrencyID . "\n";
    echo "TotalAmount = " . $TotalAmount . "\n";
    echo "XID = " . $XID . "\n";
    echo "PurchaseTime = " . $PurchaseTime . "\n";
    echo "Response.action= reverse \n";
    echo "Response.reason= something goes wrong \n";
    echo "Response.forwardUrl=  \n";
}

?>