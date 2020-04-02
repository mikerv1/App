<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/autoload/{*}.php'),
]);
//var_dump($aggregator->getMergedConfig()); exit();
return $aggregator->getMergedConfig();
