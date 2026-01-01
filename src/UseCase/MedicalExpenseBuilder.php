<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\UseCase;

use Nanaweb\MynaIryohiToCsv\Data\MedicalExpense;

class MedicalExpenseBuilder
{
    private string $yearMonth = '';
    private string $medicalInstitutionName = '';
    private int $benefits = 0;
    private int $expense = 0;

    public function withYearMonth(string $yearMonth): self
    {
        $this->yearMonth = $yearMonth;
        return $this;
    }

    public function withMedicalInstitutionName(string $medicalInstitutionName): self
    {
        $this->medicalInstitutionName = $medicalInstitutionName;
        return $this;
    }

    public function withBenefits(int $benefits): self
    {
        $this->benefits = $benefits;
        return $this;
    }

    public function withExpense(int $expense): self
    {
        $this->expense = $expense;
        return $this;
    }

    public function build(): MedicalExpense
    {
        return new MedicalExpense($this->yearMonth, $this->medicalInstitutionName, $this->benefits, $this->expense);
    }

    public function clear(): self
    {
        $this->yearMonth = '';
        $this->medicalInstitutionName = '';
        $this->benefits = 0;
        $this->expense = 0;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->yearMonth !== '' && $this->medicalInstitutionName !== '' && $this->expense !== 0;
    }
}
