<?php

namespace App\Command;

use App\Entity\Filesystem;
use App\Repository\FilesystemRepository;
use App\Service\FileReader;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NetpayGenerateDataCommand extends Command
{

    const DEFAULT_DEMO_FILE = __DIR__ . '/../../demo/file.txt';

    protected static $defaultName = 'netpay:generate-data';
    /**
     * @var FilesystemRepository
     */
    private $repository;
    /**
     * @var string
     */
    private $name;


    public function __construct(FilesystemRepository $repository, string $name = null)
    {
        parent::__construct($name);
        $this->repository = $repository;
        $this->name = $name;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'File that need to be imported into the database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $file = $input->getOption('file');
        if (empty($file)) {
            $io->note('No file given so defaulting to the sample file');
            $file = self::DEFAULT_DEMO_FILE;
        }

        try {
            $contents = new FileReader($file);
        } catch (Exception $e) {
            $io->error('File do not exist' );
            exit;
        }

        $this->repository->createQueryBuilder('f')->delete()->getQuery()->execute();

        foreach ($contents->iterate() as $line) {
            if(empty(trim($line))) {
                continue;
            }
            $filePath = str_replace('\\','/',$line);
            $filePathInfo = pathinfo($filePath);
            $this->ensureDirectoryExist($filePathInfo['dirname']);

            $pathId = $this->repository->getPathId($filePathInfo['dirname']);
            $file = new Filesystem();
            $file->setParent($this->repository->find($pathId));
            $file->setTitle($filePathInfo['basename']);
            $this->repository->save($file);
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }

    private function ensureDirectoryExist(string $dirname)
    {
        if ($dirname === '.') {
            return true;
        }
        if (!$this->repository->pathExists($dirname)) {
            $pathInfo = pathinfo($dirname);
            if ($this->ensureDirectoryExist($pathInfo['dirname'])) {
                $path = null;
                if ($pathInfo['dirname'] ) {
                    $pathId = $this->repository->getPathId($pathInfo['dirname']);
                    $path = $pathId ? $this->repository->find($pathId) : null;
                }
                $file = new Filesystem();
                $file->setParent($path);
                $file->setTitle($pathInfo['basename']);
                $this->repository->save($file);
            }
        }
        return true;
    }
}
