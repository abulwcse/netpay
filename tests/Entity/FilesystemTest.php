<?php


namespace App\Tests\Entity;

use App\Entity\Filesystem;
use PHPUnit\Framework\TestCase;

class FilesystemTest extends TestCase
{
    const TEST_TITLE = 'foo';

    const TEST_PARENT = null;

    /**
     * @var Filesystem
     */
    private $file;

    public function setUp()
    {
        $this->file = new Filesystem();
        $this->file->setTitle(self::TEST_TITLE)
            ->setParent(self::TEST_PARENT);
    }

    public function testGetTitle()
    {
        $this->assertEquals(self::TEST_TITLE, $this->file->getTitle());
    }

    public function testGetParent()
    {
        $this->assertEquals(self::TEST_PARENT, $this->file->getParent());
    }

}
