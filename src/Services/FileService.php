<?php

declare(strict_types=1);

namespace App\Services;

use App\Ftp\Ftp;
use App\Entity\File;
use App\Repository\FileRepository;

class FileService {
    
    private $ftp;
    private object $repo;
    
    public function __construct(FileRepository $repo, Ftp $ftp) {
        $this->repo = $repo;
        $this->ftp = $ftp;
    }
    
    public function createFile() : void {
        $getFTpFile = $this->ftp->getZipArchive()->extractFromZip()->parsToTxt();
        
        $file = new File(getcwd() . '/downloaded/txt/', new \DateTime(), $getFTpFile->fileTxt);
        
        $this->repo->save($file);
    }
}
