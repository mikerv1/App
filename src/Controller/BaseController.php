<?php

declare(strict_types=1);

namespace App\Controller;

DI\Container;

class BaseController
{
    public $connect;
    
    public function __construct($connect)
    {
        $this->container = $connect;
    }
}
