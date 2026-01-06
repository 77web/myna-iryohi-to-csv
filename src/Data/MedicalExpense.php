<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\Data;

readonly class MedicalExpense
{
    public ?string $isMedicalCare;
    public ?string $isPharmacy;
    public ?string $isNursingCare;
    public ?string $isOther;


    public function __construct(
        public string $yearMonth,
        MedicalExpenseType $type,
        public string $medicalInstitutionName,
        public int $benefits,
        public int $expense,
    ) {
        $this->isMedicalCare = $type === MedicalExpenseType::MEDICAL_CARE ? '該当する' : null;
        $this->isPharmacy = $type === MedicalExpenseType::PHARMACY ? '該当する' : null;
        $this->isNursingCare = null;
        $this->isOther = null;
    }
}
