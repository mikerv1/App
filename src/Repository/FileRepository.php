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

    public function save(File $file) : void {
        
        $sql = 'INSERT INTO files (file_name, archive_name, created_at, updated_at, status, description) VALUES (:file_name, :archive_name, :created_at, :updated_at, :status, :description)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':file_name' => $file->fileName,
            ':archive_name' => $file->archiveName,
            ':created_at' => $file->created_at->format('Y-m-d H:i:s'),
            ':updated_at' => $file->updated_at->format('Y-m-d H:i:s'),
            ':status' => $file->status,
            ':description' => $file->description
        ]);
    }
    
    public function updateStatus(File $file) : void {
        
        $sql = 'UPDATE files SET status = (:status) WHERE id = (:id)';
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            ':id' => $file->id,
            ':status' => $file->status
        ]);
    }

    public function getLastFile() : File {
        
        $sql = 'SELECT *
                FROM files
                WHERE updated_at=(SELECT MAX(updated_at) FROM files)
                AND status="active"';
        
        //$sql = 'SELECT id, file_name, archive_name, created_at, updated_at, status, description FROM files WHERE status="active"';
        $stmt = $this->pdo->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        $stmt->execute();
        $obj = $stmt->fetch();
        
        if (!$obj) {
            throw new \Exception("file is not exist");
        }
        
        $file = File::createFileViaHandle((int)$obj->id,
                                          $obj->file_name,
                                          $obj->archive_name,
                                          new \DateTimeImmutable($obj->created_at),
                                          new \DateTimeImmutable($obj->updated_at),
                                          $obj->status, 
                                          (string)$obj->description);
        return $file;
    }
}
