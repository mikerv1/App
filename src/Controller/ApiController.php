<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\FileRepository;
use App\Services\ApiService;

class ApiController {
    
    private object $repo;
    private object $api;

    public function __construct(FileRepository $repo, ApiService $api) {
        $this->repo = $repo;
        $this->api = $api;
    }
    
    public function apiAction() : string {
        
        $lastFile = $this->repo->getLastFile();
        $this->api->getData($lastFile);
        
        return $this->api->getData($lastFile);
    }
}
