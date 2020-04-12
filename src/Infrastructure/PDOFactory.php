<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Monolog\Logger;
use Psr\Container\ContainerInterface;

class PDOFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['pdo'];
        $log = $container->get(Logger::class);
        try {
            return new \PDO("sqlite:" .  $config['dsn'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (\PDOException $e) {
            $log->info($e->getMessage() . 'DB error connection');
            die();
        }
        
        chmod(getcwd() . '/DB/' . $config['dsn'], 0777);
    }
}
