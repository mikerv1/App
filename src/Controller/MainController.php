<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\SQLiteConnection;

class MainController
{
    public $connect;
    
    public function __construct(SQLiteConnection $connect)
    {
        $this->connect = $connect;
    }
}
