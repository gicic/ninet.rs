<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    '2co' => [
        'sid'         => env('2CO_SID'),
        'public_key'  => env('2CO_PUBLIC_KEY'),
        'private_key' => env('2CO_PRIVATE_KEY'),
        'secret_word' => env('2CO_SECRET_WORD'),
        'env_mode'    => env('2CO_ENV_MODE')
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_CALLBACK_URI', 'http://localhost:8000/socialite-callback/facebook'),
    ],

    'twitter' => [
        'client_id'     => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect'      => '',
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => '',
    ],

    'solus_master' => [
        'api_id'  => env('SOLUS_MASTER_API_ID'),
        'api_key' => env('SOLUS_MASTER_API_KEY'),
        'api_url' => env('SOLUS_MASTER_API_URL'),
    ],

    // OneTimeSecret parameters
    'ots'   => [
        'client_id' => env('ONE_TIME_SECRET_CLIENT_ID'),
        'token'     => env('ONE_TIME_SECRET_TOKEN'),
        'tll'       => env('ONE_TIME_SECRET_TLL'),
    ],

    'eracuni' => [
        'username' => env('ERACUNI_API_USERNAME'),
        'password' => env('ERACUNI_API_MD5PASS'),
        'token'    => env('ERACUNI_API_TOKEN'),
    ],

    'godaddy' => [
        'base_url'   => env('GODADDY_BASE_URL'),
        'api_key'    => env('GODADDY_API_KEY'),
        'shopper_id' => env('GODADDY_SHOPPER_ID'),
    ],

    'rnids' => [
        'hostname' => env('RNIDS_HOSTNAME'),
        'username' => env('RNIDS_USERNAME'),
        'password' => env('RNIDS_PASSWORD'),
        'port'     => env('RNIDS_PORT', 700),
    ],

    'resello' => [
        'api_url' => env('RESELLO_API_URL'),
        'api_key' => env('RESELLO_API_KEY'),
    ],

    'core-api' => [
        'baseUrl' => env('CORE_API_BASE_URL'),
        'clientSecret' => env('CORE_API_CLIENT_SECRET'),
        'clientID' => env('CORE_API_CLIENT_ID'),
    ],

    'realtime' => [
        'url' => env('REALTIME_API_URL'),
        'api_key' => env('REALTIME_API_KEY'),
        'customer' => env('REALTIME_API_CUSTOMER'),
    ],
];
