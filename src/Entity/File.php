<?php

declare(strict_types=1);

namespace App\Entity;

class File {
    
    public const ACTIVE = 'active';
    public const CLOSED = 'closed';
    
    public int $id;
    public string $fileName;
    public string $archiveName;
    public object $created_at;
    public object $updated_at;
    public string $status;
    public string $description;
    
    public function __construct(string $fileName,
                                string $archiveName,
                                \DateTimeImmutable $created_at,
                                \DateTimeImmutable $updated_at,
                                $description)
    {
        $this->fileName = $fileName;
        $this->archiveName = $archiveName;
        $this->created_at = $created_at ?? new \DateTimeImmutable();
        $this->updated_at = $updated_at ?? new \DateTimeImmutable();
        $this->status = $this->status ?? self::ACTIVE;
        $this->description = $description ?? '';
    }
    
    public static function createFileViaHandle(int $id,
                                         string $fileName,
                                         string $archiveName,
                                         \DateTimeImmutable $created_at,
                                         \DateTimeImmutable $updated_at,
                                         string $status, 
                                         string $description) : self
    {
        $file = new self($fileName, $archiveName, $created_at, $updated_at, $description);
        $file->id = $id;
        $file->status = $status;
//        $file->description = $description;
        
        return $file;
    }
    
    public function isClosed(): bool
    {
        return $this->status === self::CLOSED;
    }

    public function isActive(): bool
    {
        return $this->status === self::ACTIVE;
    }
    
    public function onClosed() : void {
        $this->status = self::CLOSED;
    }
}
