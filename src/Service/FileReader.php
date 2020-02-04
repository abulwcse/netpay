<?php


namespace App\Service;


use Exception;
use NoRewindIterator;
use SplFileObject;

class FileReader
{
    /**
     * @var SplFileObject
     */
    protected $file;

    /**
     * FileReader constructor.
     * @param $filename
     * @param string $mode
     * @throws Exception
     */
    public function __construct($filename, $mode = "r")
    {
        if (!file_exists($filename)) {
            throw new Exception("File not found");
        }
        $this->file = new SplFileObject($filename, $mode);
    }

    /**
     * @return \Generator|int
     */
    protected function iterateText()
    {
        $count = 0;
        while (!$this->file->eof()) {
            yield $this->file->fgets();
            $count++;
        }
        return $count;
    }


    /**
     * @return NoRewindIterator
     */
    public function iterate()
    {
        return new NoRewindIterator($this->iterateText());
    }
}