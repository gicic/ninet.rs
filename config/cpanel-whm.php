<?php 
return [
    'servers' => [
        // Array key not necessary unless you have multiple servers
        'server_3' => [
            /*
            |--------------------------------------------------------------------------
            | Host of your server
            |--------------------------------------------------------------------------
            |
            | Please provide this by its full URL including its protocol and its port
            |
            */
            'host' => env('WHM_SERVER_3_HOST'),

            /*
            |--------------------------------------------------------------------------
            | Remote Access key
            |--------------------------------------------------------------------------
            |
            | You can find this remote access key on your CPanel/WHM server.
            | Log in to your server using root, and find `Remote Access Key`.
            | Copy and paste all of the string
            |
            */
            'auth' => env('WHM_SERVER_3_AUTH'),

            /*
            |--------------------------------------------------------------------------
            | Username
            |--------------------------------------------------------------------------
            |
            | By default, it will use root as its username. If you have another username,
            | make sure it has the same privelege with the root or at least it can access
            | External API which is provided by CPanel/WHM
            |
            */
            'username' => env('WHM_SERVER_3_USERNAME'),
        ],
        // More Servers can be listed here as a new array
    ]
];