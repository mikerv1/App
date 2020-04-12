<?php

declare(strict_types=1);

namespace App\Entity;

class File
{
    public const OPEN = 'open';
    public const CLOSED = 'closed';
    
    //private int $id;
    public string $path;
    public object $date;
    public string $name;
    
    
    public function __construct(string $path, \DateTime $date, string $name) {
        $this->path = $path;
        $this->date = $date;
        $this->name = $name;
    }
    
    public static function createNewFile(string $path, \DateTime $date, string $name) : self {
        $file = new self($path, $date, $name);
        $file->path = $path;
        $file->date = $date;
        $file->name = $name;
        return $file;
    }
}
