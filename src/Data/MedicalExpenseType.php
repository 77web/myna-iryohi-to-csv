<?php

declare(strict_types=1);

namespace Nanaweb\MynaIryohiToCsv\Data;

enum MedicalExpenseType: string
{
    case MEDICAL_CARE = '診療・治療';
    case PHARMACY = '医薬品購入';

    public static function fromMynaValue(string $mynaValue): self
    {
        return match ($mynaValue) {
            '歯科外来', '医科外来', '医科入院' => self::MEDICAL_CARE,
            '調剤' => self::PHARMACY,
        };
    }
}
