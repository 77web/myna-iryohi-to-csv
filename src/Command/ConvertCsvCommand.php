<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\Command;

use Nanaweb\MynaIryohiToCsv\UseCase\ConvertMynaCsvUseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand("app:convert-csv")]
class ConvertCsvCommand extends Command
{
    public function __construct(
        private readonly ConvertMynaCsvUseCase $useCase,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('input', InputArgument::REQUIRED, 'Input CSV file path')
            ->addArgument('output', InputArgument::REQUIRED, 'Output CSV file path')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputPath = $this->assurePath($input->getArgument('input'));
        $outputPath = $this->assurePath($input->getArgument('output'));

        try {
            $this->useCase->__invoke(
                $outputPath,
                new \SplFileObject($inputPath),
            );
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function assurePath(string $path): string
    {
        if ($path[0] !== '/') {
            return getcwd() . DIRECTORY_SEPARATOR . $path;
        }
        return $path;
    }
}
