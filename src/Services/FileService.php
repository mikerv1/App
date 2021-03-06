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
    
    public function getDataArchiveFile() : array {
        
        $ftp = $this->ftp->init();
        
        return [
            'archiveName' => $ftp->name,
            'archiveUpdatedAt' => new \DateTimeImmutable($ftp->getFileTime())
        ];  
    }
    
    
    
    public function createFile() : void {
        
        $dataArchiveFile = $this->getDataArchiveFile();
        
        try {
            $lastFile = $this->repo->getLastFile();
        } catch (\Exception $e) {
            $downloadFile = $this->downloadArchiveFile($dataArchiveFile);
            $this->repo->save($downloadFile);
            throw $e;
        }
        
        if ($lastFile->isActive() &&
            ($lastFile->archiveName !== $dataArchiveFile['archiveName'] ||
            $lastFile->updated_at->format('Y-m-d H:i') !== $dataArchiveFile['archiveUpdatedAt']->format('Y-m-d H:i'))) {
            
            $downloadFile = $this->downloadArchiveFile($dataArchiveFile);

            $lastFile->onClosed();
            $this->repo->updateStatus($lastFile);

            $this->repo->save($downloadFile);
        }
    }
    
    public function  getData(string $fileName, object $date) : string {
        
        $month = $date->format('n');
        
        $symbolsMonth = ['JAN21', 'FEB21', 'MAR21', 'APR20', 'MAY20', 'JUN20', 'JUL20', 'AUG20', 'SEP20', 'OCT20', 'NOV20', 'DEC20'];
        
        $getSymbolMonth = $symbolsMonth[$month - 1];
        
        //$getSymbolMonth = 'JUN20';
        
        $lines = file($fileName);
        
        foreach($lines as $num_line => $line_value)
        {
            if(strpos($line_value, $getSymbolMonth) !== FALSE) {
                $line[] = $num_line;
            }
        }
        
        $stream = new FileReader($fileName);
        
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
        
        return json_encode($chunkArray);
    }
    
    private function divide_sample(string $sample_number) : array {
        
      preg_match("/([a-zA-Z]*)([\-0-9]*)/", $sample_number, $pieces);

      return [$pieces[0]];
    }
    
    private function downloadArchiveFile(array $dataArchiveFile) : File {
        
        $downloadFile = $this->ftp->init()->getZipArchive()->extractFromZip()->parsToTxt();
        $getFtpFile = $downloadFile->fileTxt;
        $data = $this->getData(getcwd() . '/downloaded/txt/' . $getFtpFile, $dataArchiveFile['archiveUpdatedAt']);
            
        return new File(getcwd() . '/downloaded/txt/' . $getFtpFile,
                        $dataArchiveFile['archiveName'],
                        new \DateTimeImmutable(),
                        $dataArchiveFile['archiveUpdatedAt'],
                        $data);
    }
}
