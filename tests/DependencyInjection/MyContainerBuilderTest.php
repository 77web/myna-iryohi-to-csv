<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\Tests\DependencyInjection;

use Nanaweb\MynaIryohiToCsv\Command\ConvertCsvCommand;
use Nanaweb\MynaIryohiToCsv\DependencyInjection\MyContainerBuilder;
use Nanaweb\MynaIryohiToCsv\UseCase\ConvertMynaCsvUseCase;
use PHPUnit\Framework\TestCase;

class MyContainerBuilderTest extends TestCase
{
    public function test(): void
    {
        $sut = new MyContainerBuilder();
        $container = $sut->build();
        $this->assertNotNull($container->get(ConvertMynaCsvUseCase::class));
        $this->assertNotNull($container->get(ConvertCsvCommand::class));
    }
}
