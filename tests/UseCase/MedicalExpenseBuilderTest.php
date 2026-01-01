<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\Tests\UseCase;

use PHPUnit\Framework\TestCase;
use Nanaweb\MynaIryohiToCsv\UseCase\MedicalExpenseBuilder;

class MedicalExpenseBuilderTest extends TestCase
{
    public function testIsValidReturnsTrueWhenAllFieldsAreSet()
    {
        $builder = new MedicalExpenseBuilder()
            ->withYearMonth('2025-12')
            ->withMedicalInstitutionName('テスト病院')
            ->withBenefits(1000)
            ->withExpense(2000);
        $this->assertTrue($builder->isValid());
    }

    public function testIsValidReturnsFalseWhenYearMonthIsEmpty()
    {
        $builder = new MedicalExpenseBuilder()
            ->withYearMonth('')
            ->withMedicalInstitutionName('テスト病院')
            ->withBenefits(1000)
            ->withExpense(2000);
        $this->assertFalse($builder->isValid());
    }

    public function testIsValidReturnsFalseWhenMedicalInstitutionNameIsEmpty()
    {
        $builder = new MedicalExpenseBuilder()
            ->withYearMonth('2025-12')
            ->withMedicalInstitutionName('')
            ->withBenefits(1000)
            ->withExpense(2000);
        $this->assertFalse($builder->isValid());
    }

    public function testIsValidReturnsFalseWhenExpenseIsZero()
    {
        $builder = new MedicalExpenseBuilder()
            ->withYearMonth('2025-12')
            ->withMedicalInstitutionName('テスト病院')
            ->withBenefits(1000)
            ->withExpense(0);
        $this->assertFalse($builder->isValid());
    }

    public function testBuildReturnsMedicalExpenseWithCorrectValues()
    {
        $yearMonth = '2025-12';
        $medicalInstitutionName = 'テスト病院';
        $benefits = 1000;
        $expense = 2000;
        $builder = new MedicalExpenseBuilder()
            ->withYearMonth($yearMonth)
            ->withMedicalInstitutionName($medicalInstitutionName)
            ->withBenefits($benefits)
            ->withExpense($expense);
        $medicalExpense = $builder->build();
        $this->assertSame($yearMonth, $medicalExpense->yearMonth);
        $this->assertSame($medicalInstitutionName, $medicalExpense->medicalInstitutionName);
        $this->assertSame($benefits, $medicalExpense->benefits);
        $this->assertSame($expense, $medicalExpense->expense);
    }
}
