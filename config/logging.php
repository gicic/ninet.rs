<?php

use App\Loggers\EracuniLogger;
use App\Loggers\GoDaddyLogger;
use App\Loggers\RaiffeisenLogger;
use App\Loggers\OrderLogger;
use App\Loggers\PayPalLogger;
use App\Loggers\ReselloLogger;
use App\Loggers\RnidsLogger;
use App\Loggers\RouterOSLogger;
use App\Loggers\SocialLogger;
use App\Loggers\SolusLogger;
use App\Loggers\TwoCheckoutLogger;
use App\Loggers\WHMLogger;
use Monolog\Handler\StreamHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily'],
        ],

        'order' => [
            'driver' => 'custom',
            'via' => OrderLogger::class,
            'formatting' => 'default',
        ],

        'social' => [
            'driver' => 'custom',
            'via' => SocialLogger::class,
            'formatting' => 'default',
        ],

        'solus' => [
            'driver' => 'custom',
            'via' => SolusLogger::class,
            'formatting' => 'default',
        ],

        'whm' => [
            'driver' => 'custom',
            'via' => WHMLogger::class,
            'formatting' => 'default',
        ],

        '2co' => [
            'driver' => 'custom',
            'via' => TwoCheckoutLogger::class,
            'formatting' => 'default',
        ],

        'paypal' => [
            'driver' => 'custom',
            'via' => PayPalLogger::class,
            'formatting' => 'default',
        ],

        'nestpay' => [
            'driver' => 'custom',
            'via' => RaiffeisenLogger::class,
            'formatting' => 'default',
        ],

        'eracuni' => [
            'driver' => 'custom',
            'via' => EracuniLogger::class,
            'formattion' => 'default',
        ],

        'godaddy' => [
            'driver' => 'custom',
            'via' => GoDaddyLogger::class,
            'formattion' => 'default',
        ],

        'rnids' => [
            'driver' => 'custom',
            'via' => RnidsLogger::class,
            'formattion' => 'default',
        ],

        'resello' => [
            'driver' => 'custom',
            'via' => ReselloLogger::class,
            'formattion' => 'default',
        ],

        'router-os' => [
            'driver' => 'custom',
            'via' => RouterOSLogger::class,
            'formattion' => 'default',
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],

];
