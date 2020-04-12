<?php

declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            PDO::class => App\Infrastructure\PDOFactory::class,
        ]
    ]
];
