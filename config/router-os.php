<?php

return [

    'routers' => [
        'router1' => [
            'host'   => env('ROUTER_1_HOST', ''),
            'port'   => env('ROUTER_1_PORT', ''),
            'user'   => env('ROUTER_1_USER', ''),
            'pass'   => env('ROUTER_1_PASS', ''),
            'legacy' => env('ROUTER_1_LEGACY', true),
        ],
        'router2' => [
            'host'   => env('ROUTER_2_HOST', ''),
            'port'   => env('ROUTER_2_PORT', ''),
            'user'   => env('ROUTER_2_USER', ''),
            'pass'   => env('ROUTER_2_PASS', ''),
            'legacy' => env('ROUTER_2_LEGACY', true),
        ],
    ]

];