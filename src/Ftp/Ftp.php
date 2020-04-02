<?php

declare(strict_types=1);

namespace App\Ftp;

use ZipArchive;

class Ftp
{
    public $connect;
    public $name;
    
    public function __construct($connect)
    {
        $this->connect = ftp_connect($connect);
        //$this->logger = $logger;
    }
    
//    public function __call($func, $a)
//    {
//        if(strstr($func, 'ftp_') !== false && function_exists($func)){
//            array_unshift($a, $this->ftp);
//            return call_user_func_array($func, $a);
//        }else{
//            // replace with your own error handler.
//            //$this->logger->info("$func is not a valid FTP function");
//            die();
//        }
//    }
    
    public function getZipArchive()
    {
        //$this->ftp_connect();
        ftp_login($this->connect, 'anonymous','');
        ftp_pasv($this->connect, true);
        $list = ftp_nlist($this->connect, '/bulletin');
        $fileCount = count($list);
        //$buff = $this->ftp_mdtm($list[$fileCount - 1]);
        $this->name = substr(($list[$fileCount - 1]), 10);
        if (ftp_get($this->connect, getcwd() . '/downloaded/' . $this->name, $list[$fileCount - 1], FTP_BINARY)) {
            echo "File downloaded\n";
        } else {
            echo "File wasn't downloaded\n"; 
        }
        chmod(getcwd() . '/downloaded/' . $this->name, 0777);
        
        return $this;
    }
    
    public function extractFromZip()
    {
        $zip = new ZipArchive();
        $zip->open(getcwd() . '/downloaded/' . $this->name , ZipArchive::CREATE);
        $zip->extractTo(getcwd() . '/downloaded/unzip/', 'DailyBulletin_2020040163.pdf');
        $zip->close();
        
        chmod(getcwd() . '/downloaded/unzip/DailyBulletin_2020040163.pdf', 0777);
    }
}
