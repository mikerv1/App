<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\FileRepository;

class ApiController {
    
    private object $repo;
    
    public function __construct(FileRepository $repo) {
        $this->repo = $repo;
    }
    
    public function apiAction() : string {
        $result = $this->repo->getLastFile();
        return $result->description;
        //echo $result->description;
    }
}
