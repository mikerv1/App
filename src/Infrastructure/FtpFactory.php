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
        $fileName = $container->get('config')['ftp']['fileName'];
        return new Ftp($connect, $fileName);
    }
}
