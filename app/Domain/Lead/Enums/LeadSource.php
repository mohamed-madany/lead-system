<?php

namespace App\Domain\Lead\Enums;

use Filament\Support\Contracts\HasLabel;

enum LeadSource: string implements HasLabel
{
    case FORM = 'form';
    case REFERRAL = 'referral';
    case CAMPAIGN = 'campaign';
    case MANUAL = 'manual';
    case IMPORT = 'import';
    case API = 'api';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FORM => 'نموذج الموقع',
            self::REFERRAL => 'توصية',
            self::CAMPAIGN => 'حملة تسويقية',
            self::MANUAL => 'إدخال يدوي',
            self::IMPORT => 'استيراد بيانات',
            self::API => 'ربط برمجى (API)',
        };
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->getLabel();
        }

        return $options;
    }
}
