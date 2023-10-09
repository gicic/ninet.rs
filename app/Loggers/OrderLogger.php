<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 19.7.2018.
 * Time: 11:42
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class OrderLogger
{
    public function __invoke(array $config)
    {
        return new Logger('order', [new StreamHandler(storage_path('logs/order/order-' . date('Y-m-d') . '.log'))]);
    }
}