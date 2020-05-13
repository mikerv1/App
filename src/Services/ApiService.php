<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\File;

class ApiService {
    
    public function getData(File $file) : string {
        
        $array = json_decode($file->description);
        
        for ($i = 0; $i < count($array); $i ++) {
            
            if ((int)$array[$i][6]) {
                print_r($array[$i][6]);
                echo '</br>';
                $a = (float)(((int)$array[$i][0]) / 1000);
                $b = (float)(((float)$array[$i][5]) * 0.01);
                $c[] = $a - $b;
            }
        }
        
        return json_encode($c);
    }
}
