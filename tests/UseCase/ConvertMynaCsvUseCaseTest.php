<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\Tests\UseCase;

use Nanaweb\MynaIryohiToCsv\Data\MedicalExpense;
use Nanaweb\MynaIryohiToCsv\UseCase\ConvertMynaCsvUseCase;
use Nanaweb\MynaIryohiToCsv\UseCase\FileWriter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class ConvertMynaCsvUseCaseTest extends TestCase
{
    public function test(): void
    {
        $serializerMock = $this->createMock(SerializerInterface::class);
        $fileWriteMock = $this->createMock(FileWriter::class);
        $SUT = new ConvertMynaCsvUseCase($serializerMock, $fileWriteMock);

        $serializerMock->expects($this->once())
            ->method('serialize')
            ->with($this->callback(function (array $arg) {
                /** @var MedicalExpense[] $arg */
                $this->assertCount(4, $arg);
                $this->assertEquals('2025年1月', $arg[0]->yearMonth);
                $this->assertEquals('PHPクリニック', $arg[0]->medicalInstitutionName);
                $this->assertEquals('2025年2月', $arg[1]->yearMonth);
                $this->assertEquals('Symfony薬局', $arg[1]->medicalInstitutionName);
                $this->assertEquals('2025年2月', $arg[2]->yearMonth);
                $this->assertEquals('Doctrine病院', $arg[2]->medicalInstitutionName);
                $this->assertEquals('2025年3月', $arg[3]->yearMonth);
                $this->assertEquals('Twig歯科医院', $arg[3]->medicalInstitutionName);

                return true;
            }), 'csv')
            ->willReturn('dummy-csv')
        ;
        $fileWriteMock->expects($this->once())
            ->method('write')
            ->with('/path/to/output.csv', 'dummy-csv')
        ;

        $SUT('/path/to/output.csv', new \SplFileObject(__DIR__ . '/input.csv'));
    }
}
