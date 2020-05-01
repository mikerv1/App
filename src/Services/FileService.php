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
        $getFTPFile = $this->ftp->getZipArchive()->extractFromZip()->parsToTxt();
        
        $file = new File(getcwd() . '/downloaded/txt/' . $getFTPFile->fileTxt, new \DateTimeImmutable());
        
        if($this->repo->getMaxId()) {
            $lastFile = $this->repo->getLastFile();
            if($lastFile->status === File::ACTIVE) {
                $lastFile->onClosed();
                $this->repo->updateStatus($lastFile);
            }
        }
        
        $this->repo->save($file);
    }
    
    public function  getData() : void {
        
        $file = $this->repo->getLastFile();
        
        $date = $file->date->format('n');
        
        $symbolsMonth = ['JAN21', 'FEB21', 'MAR21', 'APR20', 'MAY20', 'JUN20', 'JUL20', 'AUG20', 'SEP20', 'OCT20', 'NOV20', 'DEC20'];
        
//        $getSymbolMonth = $symbolsMonth[$date - 1];
        
        $getSymbolMonth = 'JUN20';
        
       $lines = file($file->name);
 
        foreach($lines as $num_line => $line_value)
        {
            if(strpos($line_value, $getSymbolMonth) !== FALSE) {
                $line[] = $num_line;
            }
        }
        
        $stream = new FileReader($file->name);
        
        $stream->SetOffset($line[0]);
        $result = $stream->Read(1);
        
        //$pos = strripos($result[0], "MAY20");
        $pos = stripos($result[0], $getSymbolMonth);
        
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
        
        \Symfony\Component\VarDumper\VarDumper::dump($chunkArray); exit();
        
        $jsonData = json_encode($chunkArray);
        
        if($this->repo->getMaxId()) {
            $lastFile = $this->repo->getLastFile();
            if($lastFile->status === File::ACTIVE) {
                $lastFile->description = $jsonData;
                $this->repo->updateDescription($lastFile);
            }
        }
    }
    
    private function divide_sample(string $sample_number) : array {
      preg_match("/([a-zA-Z]*)([\-0-9]*)/", $sample_number, $pieces);

      return [$pieces[0]];
    }
    
//    private function calculation ($chunkArray) : array {
//        
//    }
}
