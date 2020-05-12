<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\FileService;
use App\Migrations\FilesMigration;
use Monolog\Logger;

class FileController {
    private object $service;
    private object $filesMigration;
    private object $log;
    
    public function __construct(FileService $service,
                                FilesMigration $filesMigration,
                                Logger $log)
    {
        $this->service = $service;
        $this->filesMigration = $filesMigration;
        $this->log = $log;
    }
    
    public function migrate() : void {
        $this->filesMigration->migrateTableFiles();
    }
    
    public function getFile() : void {
        try {
            $this->service->createFile();
        }
        catch (\Exception $e)
        {
            $this->log->info($e->getMessage());
        }
    }
    
    public function checkFile() : array {
        return $this->service->getDataArchiveFile();
    }
}
