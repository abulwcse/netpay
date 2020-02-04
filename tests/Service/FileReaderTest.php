<?php

namespace App\Tests\Service;

use App\Service\FileReader;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{

    /**
     * @var FileReader
     */
    private $reader;

    public function setUp()
    {
        $this->reader = new FileReader(__DIR__ . '/Fixture/foo.txt');
    }

    public function testIterate()
    {
        $lineContent = 1;
        foreach ($this->reader->iterate() as $line) {
            if (empty($line)) {
                // excluding the last empty line
                continue;
            }
            $this->assertEquals(strval($lineContent), trim($line));
            $lineContent++;
        }
    }
}
