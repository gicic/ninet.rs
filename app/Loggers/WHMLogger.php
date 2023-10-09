<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 8.10.2018.
 * Time: 10:43
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class WHMLogger
{
    public function __invoke(array $config)
    {
        return new Logger('whm', [new StreamHandler(storage_path('logs/whm/whm-' . date('Y-m-d') . '.log'))]);
    }
}