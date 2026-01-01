<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\UseCase;

class FileWriter
{
    public function write(
        string $path,
        string $csv,
    ): void {
        file_put_contents($path, $csv);
    }
}
