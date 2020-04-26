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
        
        $sql = 'INSERT INTO files (name, date, status, description)'
                . 'VALUES (:name, :date, :status, :description)';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $file->name,
            ':date' => $file->date->format('Y-m-d H:i:s'),
            ':status' => $file->status,
            ':description' => $file->description
        ]);

        return $this->pdo->lastInsertId();
    }
    
    public function updateStatus(File $file) : void {
        
        $sql = 'UPDATE files SET status = (:status) WHERE id = (:id)';
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            ':id' => $file->id,
            ':status' => $file->status
        ]);
    }
    
    public function updateDescription(File $file) : void {
        
        $sql = 'UPDATE files SET description = (:description) WHERE id = (:id)';
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            ':id' => $file->id,
            ':description' => $file->description
        ]);
    }

    public function getLastFile() : ?File {
        
        $sql = 'SELECT id, name, date, status, description from files WHERE status="active"';
        $stmt = $this->pdo->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        $stmt->execute();
        $obj = $stmt->fetch();
        $file = File::createFileViaHandle((int)$obj->id,
                                          $obj->name, 
                                          new \DateTimeImmutable($obj->date), 
                                          $obj->status, 
                                          (string)$obj->description);
        return $file;
    }
}
