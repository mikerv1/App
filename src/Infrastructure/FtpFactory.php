<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Ftp\Ftp;
use Psr\Container\ContainerInterface;

class FtpFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $connect = $container->get('config')['ftp']['connect'];
        //var_dump($connect); exit();
        return new Ftp($connect);
    }
}
