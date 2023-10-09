<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 18.10.2018.
 * Time: 09:25
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ReselloLogger
{
    public function __invoke(array $config)
    {
        return new Logger('resello', [new StreamHandler(storage_path('logs/resello/resello-' . date('Y-m-d') . '.log'))]);
    }
}