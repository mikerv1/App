<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Psr\Container\ContainerInterface;

class PDOFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['pdo'];

        return new \PDO("sqlite:" .  $config['dsn'],
            $config['username'],
            $config['password'],
            $config['options']
        );
    }
}
