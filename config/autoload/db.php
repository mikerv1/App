<?php

declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            PDO::class => App\Infrastructure\PDOFactory::class,
        ]
    ],

    'pdo' => [
        'dsn' => 'DB/phpsqlite.db',
        'username' => '',
        'password' => '',
        'options' => [
            \PDO::ATTR_PERSISTENT => true
        ],
    ],
    
    'ftp' => [
        'connect' => 'ftp.cmegroup.com'
    ],
];

