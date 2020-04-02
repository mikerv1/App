#!/usr/bin/env php
<?php

declare(strict_types=1);

chdir(dirname(__DIR__));

require dirname(__DIR__).'/vendor/autoload.php';

use Symfony\Component\Console\Input\ArgvInput;


if (false === in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true)) {
    echo 'Warning: The console should be invoked via the CLI version of PHP, not the '
    .\PHP_SAPI.' SAPI'.\PHP_EOL;
}

$input = new ArgvInput();
if (null !== $env = $input->getParameterOption(['--env', '-e'], null, true)) {
    putenv('APP_ENV='.$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = $env);
}


$container = require 'config/container.php';

//echo getcwd() . "\n";

$start = microtime(true);


$app = $container->get(App\Application::class);
$app->download();

//\Symfony\Component\VarDumper\VarDumper::dump($container->get(App\Application::class)); exit();

//$ftp = $container->get(App\Ftp\Ftp::class);
//$ftp->getZipArchive();
//$ftp->extractFromZip();

echo "<pre>";
print_r(error_get_last());
echo"executed:". (microtime(true) - $start) . \PHP_EOL;
