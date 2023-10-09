<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 29.8.2018.
 * Time: 09:38
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class RaiffeisenLogger
{
    public function __invoke(array $config)
    {
        return new Logger('raiffeisen', [new StreamHandler(storage_path('logs/raiffeisen/raiffeisen-' . date('Y-m-d') . '.log'))]);
    }
}