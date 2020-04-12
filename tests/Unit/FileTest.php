<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\File;

class FileTest extends TestCase {
    
    public function testFile() {
        $file = new File('fsdfsfsfsf', new \DateTime(), 'saasdadadada');
        var_dump($file);
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
