<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 17.10.2018.
 * Time: 11:57
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class RnidsLogger
{
    public function __invoke(array $config)
    {
        return new Logger('rnids', [new StreamHandler(storage_path('logs/rnids/rnids-' . date('Y-m-d') . '.log'))]);
    }
}