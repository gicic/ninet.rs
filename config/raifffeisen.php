<?php

return [

    'nestpay_url' => env('RAIFFEISEN_URL', ''),

    'terminal_id' => env('RAIFFEISEN_TERMINAL_ID', ''),

    'merchant_id' => env('RAIFFEISEN_MERCHANT_ID', ''),

    'storetype' => '3d_pay_hosting',

    'trantype' => 'Auth',

    'lang' => 'sr',

    'hashAlgorithm' => 'ver2',

    'encoding' => 'utf-8',

    'currency' => '941',

];