<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 21.8.2018.
 * Time: 10:53
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class PayPalLogger
{
    public function __invoke(array $config)
    {
        return new Logger('paypal', [new StreamHandler(storage_path('logs/paypal/paypal-' . date('Y-m-d') . '.log'))]);
    }
}