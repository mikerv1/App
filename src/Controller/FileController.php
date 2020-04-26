<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\FileService;
use App\Migrations\FilesMigration;
//use Monolog\Logger;
//use App\Repository\FileRepository;
//
//use App\Migrations\FilesMigration;
//use Smalot\PdfParser\Parser;

class FileController {
    private object $service;
    private object $filesMigration;
//    private object $ftp;
//    private object $log;
//    private object $file;
//    private object $migration;
    
    public function __construct(FileService $service, FilesMigration $filesMigration)
    {
        $this->service = $service;
        $this->filesMigration = $filesMigration;
//        $this->ftp = $ftp;
//        $this->log = $log;
//        $this->file = $file;
//        $this->migration = $migration;
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
            die();
        }
    }
    
    public function getData() : void {
        $this->service->getData();
    }
}
