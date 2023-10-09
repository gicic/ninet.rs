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

class SocialLogger
{
    public function __invoke(array $config)
    {
        return new Logger('social', [new StreamHandler(storage_path('logs/social/social-' . date('Y-m-d') . '.log'))]);
    }
}