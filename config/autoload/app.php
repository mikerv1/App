<?php

declare(strict_types=1);

use App\Ftp\Ftp;
use Monolog\Logger;
use App\Controller\FileController;

return [
    'dependencies' => [
        'abstract_factories' => [
            Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        
        'factories' => [
            FileController::class => ReflectionBasedAbstractFactory::class,
            Logger::class => App\Infrastructure\LoggerFactory::class,
            Ftp::class => App\Infrastructure\FtpFactory::class,
        ],
    ]
];
