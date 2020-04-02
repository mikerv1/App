<?php

declare(strict_types=1);

namespace App\Infrastructure;

use PDO;
use App\Application;
use App\Ftp\Ftp;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class ApplicationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Application(
            $container->get(PDO::class),
            $container->get(Ftp::class),
            $container->get(Logger::class)
        );
    }
}
