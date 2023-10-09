<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 15.10.2018.
 * Time: 11:10
 */

namespace App\Loggers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class EracuniLogger
{
    public function __invoke(array $config)
    {
        return new Logger('eracuni', [new StreamHandler(storage_path('logs/eracuni/eracuni-' . date('Y-m-d') . '.log'))]);
    }
}