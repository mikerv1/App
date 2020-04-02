<?php

declare(strict_types=1);

namespace App;

use App\Ftp\Ftp;
use Monolog\Logger;

class Application
{
    public $pdo;
    public $ftp;
    public $log;
    
    public function __construct(\PDO $pdo, Ftp $ftp, Logger $log)
    {
        $this->pdo = $pdo;
        $this->ftp = $ftp;
        $this->log = $log;
    }
    
    public function download()
    {
        //var_dump($this->ftp); exit();
        $this->ftp->getZipArchive()->extractFromZip();
    }
}
