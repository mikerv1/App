<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Entity\File;

class FileBuilder {
        
    private $name;
    private $description;

    public function __construct() {
        $this->date = new \DateTimeImmutable();
    }

    public function newFile(string $name, string $description = "") : self {
        
        $clone = clone $this;
        $clone->name = $name;
        $clone->description = $description;
        return $clone;
    }
    
    public function build() : File {
        
        $file = null;

        $file = new File(
                $this->name,
                $this->description
            );
        
        if (!$file) {
            throw new \BadMethodCallException('Specify via method.');
        }

        return $file;
    }
}
