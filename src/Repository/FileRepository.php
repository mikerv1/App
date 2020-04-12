<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\File;

class FileRepository
{
    private $pdo;
    
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function getMaxId() : int {
        $sql = 'SELECT MAX(id) from files';
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        $id = $stmt->fetch(\PDO::FETCH_NUM);
        return ((int)($id[0]));
    }
     
    public function save(File $file) : string {
        $sql = 'INSERT INTO files(path, date, name)'
                . 'VALUES(:path, :date, :name)';
 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $file->path,
            ':date' => $file->date->format('Y-m-d H:i:s'),
            ':path' => $file->name
        ]);
 
        return $this->pdo->lastInsertId();
    }
 
    public function remove(File $file) : void {
        
    }
}
