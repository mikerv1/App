<?php

declare(strict_types=1);

namespace App\Ftp;

use ZipArchive;
use Smalot\PdfParser\Parser;

class Ftp
{
    
    public string $fileTxt;
    
    private $connection;
    private string $fileName;
    private string $name;
    
    public function __construct(string $connect, string $fileName)
    {
        $this->connection = ftp_connect($connect);
        $this->fileName = $fileName;
        $this->fileTxt = '';
        $this->name = '';
    }
    
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
    
    public function init() : self {
        if ($this->name) {
            return $this;
        } else {
            ftp_login($this->connection, 'anonymous', '');
            ftp_pasv($this->connection, true);
            $list = ftp_nlist($this->connection, '/bulletin');
            $fileCount = count($list);
            $this->name = substr(($list[$fileCount - 1]), 10);

            return $this;
        }
        
    }
    
    public function closeConnect() : void {
        ftp_close($this->connection);
    }
    
    public function getZipArchive() : self {
        if (! ftp_get($this->connection, getcwd() . '/downloaded/' . $this->name, '/bulletin/' . $this->name, FTP_BINARY)) {
            throw new \Exception("file wasn't downloaded");
        }
        
        chmod(getcwd() . '/downloaded/' . $this->name, 0777);
        
        return $this;
    }
    
    public function extractFromZip() : self {
        $zip = new ZipArchive();
        $zip->open(getcwd() . '/downloaded/' . $this->name , ZipArchive::CREATE);
        $zip->extractTo(getcwd() . '/downloaded/unzip/', $this->fileName);
        $zip->close();
        
        chmod(getcwd() . '/downloaded/unzip/' . $this->fileName, 0777);
        
        return $this;
    }    
    
    public function parsToTxt() : self {        
        $parser = new Parser();
        $parsPdf = $parser->parseFile(getcwd() . '/downloaded/unzip/' . $this->fileName);
        $text = $parsPdf->getText();
        
        $this->fileTxt = self::getRandomFileName(getcwd() . '/downloaded/txt', 'txt');
        file_put_contents(getcwd() . '/downloaded/txt/' . $this->fileTxt, $text);
        
        chmod(getcwd() . '/downloaded/txt/' . $this->fileTxt, 0777);
        
//        if (file_exists(getcwd() . '/downloaded/' . $this->name)) {
//            unlink(getcwd() . '/downloaded/' . $this->name);
//        }
//        
//        if (file_exists(getcwd() . '/downloaded/unzip/' . $this->fileName)) {
//            unlink(getcwd() . '/downloaded/unzip/' . $this->fileName);
//        }
        
        return $this;
    }
    
    public static function getRandomFileName($path, $extension='') : string {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';
 
        do {
            $name = md5(microtime() . rand(0, 9999));
            $name .= $extension;
            $file = $path . $name . $extension;
        } while (file_exists($file));
 
        return $name;
    }
    
    public function getFileTime() : string {
        return date("Y-m-d H:i:s", ftp_mdtm($this->connection, '/bulletin/' . $this->name));
    }
}
