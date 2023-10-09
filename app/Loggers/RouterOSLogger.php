<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 13.12.2018.
 * Time: 10:04
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class RouterOSLogger
{
    public function __invoke(array $config)
    {
        return new Logger('rnids', [new StreamHandler(storage_path('logs/router-os/router-os-' . date('Y-m-d') . '.log'))]);
    }
}