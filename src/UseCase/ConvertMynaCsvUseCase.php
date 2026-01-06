<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\UseCase;

use Nanaweb\MynaIryohiToCsv\Data\MedicalExpenseType;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ConvertMynaCsvUseCase
{
    public function __construct(
        private SerializerInterface $serializer,
        private FileWriter $fileWriter,
    ) {
    }

    public function __invoke(
        string $outputPath,
        \SplFileObject $file,
    ): void {

        $builder = new MedicalExpenseBuilder();
        $expenses = [];
        $atLeastOneInstitution = false;
        while (!$file->eof()) {
            $row = $file->fgetcsv();
            if (count($row) !== 2) {
                continue;
            }

            switch ($row[0]) {
                case '診療年月':
                    $builder->withYearMonth($row[1]);
                    break;
                case '診療区分':
                    $builder->withType(MedicalExpenseType::fromMynaValue($row[1]));
                    break;
                case '医療機関等名称':
                    $builder->withMedicalInstitutionName($row[1]);
                    $atLeastOneInstitution = true;
                    break;
                case 'その他の公費の負担額（円）':
                    if ($atLeastOneInstitution) {
                        $builder->withBenefits($this->toMoney($row[1]));
                    }
                    break;
                case '窓口相当負担額（円）':
                    if ($atLeastOneInstitution) {
                        $builder->withExpense($this->toMoney($row[1]));
                    }
                    break;
            }

            if ($builder->isValid()) {
                $expenses[] = $builder->build();
                $builder = $builder->clear();
            }
        }

        $this->fileWriter->write($outputPath, $this->serializer->serialize($expenses, 'csv'));
    }

    /**
     * @param $row
     * @return int
     */
    public function toMoney($row): int
    {
        return intval(str_replace(',', '', $row));
    }
}
