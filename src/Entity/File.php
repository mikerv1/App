<?php

declare(strict_types=1);

namespace App\Entity;

class File {
    
    public const ACTIVE = 'active';
    public const CLOSED = 'closed';
    
    public int $id;
    public string $name;
    public object $date;
    public string $status;
    public string $description;
    
    public function __construct(string $name,
                                \DateTimeImmutable $date)
    {
        $this->name = $name;
        $this->date = $date ?? new \DateTimeImmutable();
        $this->status = $this->status ?? self::ACTIVE;
        $this->description = '';
    }
    
    public static function createFileViaHandle(int $id,
                                         string $name,
                                         \DateTimeImmutable $date,
                                         string $status, 
                                         string $description) : self
    {
        $file = new self($name, $date);
        $file->id = $id;
        $file->status = $status;
        $file->description = $description;
        
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
