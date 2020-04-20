<?php

declare(strict_types=1);

namespace App\Services;

use App\Ftp\Ftp;
use App\Entity\File;
use App\Repository\FileRepository;
use App\FileReader\FileReader;

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
    
    public function  getData() : array {
        //$getTxtFile = $this->repo->getLastFile();
        
        $stream = new FileReader(getcwd() . '/downloaded/txt/919026880516d799b2f9f56cdbea08b4.txt');
        $stream->SetOffset(31);
        $result = $stream->Read(1);
        
        //$pos = strripos($result[0], "MAY20");
        $pos = stripos($result[0], "APR20");
        
        $mod = substr($result[0], $pos + 5); // or 50 for all string
                
        $strToArray = explode("\t", $mod);
        
        $chunkArray = array_chunk($strToArray, 14);
        
        $num = count($chunkArray);
        
        $elem = $this->divide_sample($chunkArray[$num-1][0]);
        
        unset($chunkArray[$num-1]);
        
        $last = count($chunkArray) - 1;
        
        $t = $elem[0];
        
        for ($i = $last; $i >= 0; $i--) {
            
            $temp = $chunkArray[$i][0];
            
            $chunkArray[$i][0] = $t;
            
            $t = $temp;
        }
        
        return $chunkArray;        
    }
    
    private function divide_sample(string $sample_number) : array {
      preg_match("/([a-zA-Z]*)([\-0-9]*)/", $sample_number, $pieces);

      return [$pieces[0]];
    }
}
