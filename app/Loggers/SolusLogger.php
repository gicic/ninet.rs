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

class SolusLogger
{
    public function __invoke(array $config)
    {
        return new Logger('solus', [new StreamHandler(storage_path('logs/solus/solus-' . date('Y-m-d') . '.log'))]);
    }
}