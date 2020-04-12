<?php

declare(strict_types=1);

return [
    'pdo' => [
        'dsn' => 'DB/phpsqlite.db',
        'username' => '',
        'password' => '',
        'options' => [
            \PDO::ATTR_PERSISTENT => true
        ],
    ],
    
    'ftp' => [
        'connect' => 'ftp.cmegroup.com',
        'fileName' =>'Section28_British_Pound_Put_Options.pdf'
    ],
];
