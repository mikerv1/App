<?php

declare(strict_types=1);

namespace App\Data;

class PDO
{
    /**
     * PDO instance
     * @var type 
     */
    private $pdo;
    
    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect($connect) {
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:" . $connect);
        }
        return $this->pdo;
    }
}
