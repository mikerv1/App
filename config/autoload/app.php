<?php

declare(strict_types=1);

use App\Application;
use App\Ftp\Ftp;
use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

return [
    'dependencies' => [
        'abstract_factories' => [
            Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => App\Infrastructure\ApplicationFactory::class,
            Logger::class => App\Infrastructure\LoggerFactory::class,
            Ftp::class => App\Infrastructure\FtpFactory::class,
        ],
    ]
];
