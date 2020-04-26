<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Tests\Builder\FileBuilder;


class FileTest extends TestCase {
    
    public function testFile() : void {
        
        $file = new FileBuilder();
        $file->newFile('/downloaded/txt/919026880516d799b2f9f56cdbea08b4.txt', '');        
    }
    
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    
    public function testFailure()
    {
        $this->assertJsonStringEqualsJsonString(
            json_encode(['Mascot' => 'ux']),
            json_encode(['Mascot' => 'ux'])
        );
    }
}
