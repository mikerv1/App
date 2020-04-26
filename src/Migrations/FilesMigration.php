<?php

declare(strict_types=1);

namespace App\Migrations;

class FilesMigration {

    private object $pdo;
    
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function migrateTableFiles() : void {
        $commands = [
            'CREATE TABLE IF NOT EXISTS files (
                id INTEGER PRIMARY KEY,
                name  VARCHAR (255) NOT NULL,
                date TEXT,
                status VARCHAR (255) NOT NULL,
                description TEXT);'];
        
        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }
}
