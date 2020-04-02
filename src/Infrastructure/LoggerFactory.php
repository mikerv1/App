<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Container\ContainerInterface;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $log = new Logger('App');
        $log->pushHandler(new StreamHandler(
            'tmp/logs/App.log',
            Logger::INFO
        ));
        return $log;
    }
}
