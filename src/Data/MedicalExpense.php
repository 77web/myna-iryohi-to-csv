<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\Data;

readonly class MedicalExpense
{
    public function __construct(
        public string $yearMonth,
        public MedicalExpenseType $type,
        public string $medicalInstitutionName,
        public int $benefits,
        public int $expense,
    ) {
    }
}
