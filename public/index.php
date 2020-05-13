<?php

declare(strict_types=1);

$errlevel = error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('error_prepend_string', '<font color=red>');
ini_set('error_append_string', '</font>');

use FastRoute\RouteCollector;

chdir(dirname(__DIR__));

require dirname(__DIR__).'/vendor/autoload.php';

$container = require 'config/container.php';

//$start = microtime(true);

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', 'App\Controller\ApiController');
});

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;

    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        
        $getController = $container->get($controller);
        print_r($getController->apiAction());
        break;
}

//echo"executed:". (microtime(true) - $start) . \PHP_EOL;

error_reporting($errlevel);
ini_set('display_errors','Off');
