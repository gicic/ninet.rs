<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 20.8.2018.
 * Time: 16:53
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class TwoCheckoutLogger
{
    public function __invoke(array $config)
    {
        return new Logger('2co', [new StreamHandler(storage_path('logs/two-checkout/two-checkout-' . date('Y-m-d') . '.log'))]);
    }
}