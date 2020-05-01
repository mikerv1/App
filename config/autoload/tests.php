<?php

declare(strict_types=1);

use App\Tests\Unit\FileTest;

return [
    'dependencies' => [
        'factories' => [
            FileTest::class => ReflectionBasedAbstractFactory::class
        ]
    ]
];

