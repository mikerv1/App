#!/usr/bin/env php
<?php

declare(strict_types=1);

$errlevel = error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('error_prepend_string', '<font color=red>');
ini_set('error_append_string', '</font>');

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

$start = microtime(true);

$app = $container->get(App\Controller\FileController::class);
//$app->getFile();
$app->getData();
//$app->migrate();
echo"executed:". (microtime(true) - $start) . \PHP_EOL;

error_reporting($errlevel);
ini_set('display_errors','Off');
