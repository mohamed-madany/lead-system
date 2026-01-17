<?php

namespace App\Domain\Lead\Enums;

enum LeadSource: string
{
    case FORM = 'form';
    case REFERRAL = 'referral';
    case CAMPAIGN = 'campaign';
    case MANUAL = 'manual';
    case IMPORT = 'import';
    case API = 'api';
    
    public function label(): string
    {
        return match($this) {
            self::FORM => 'نموذج الموقع',
            self::REFERRAL => 'توصية',
            self::CAMPAIGN => 'حملة تسويقية',
            self::MANUAL => 'إدخال يدوي',
            self::IMPORT => 'استيراد',
            self::API => 'ربط خارجي (API)',
        };
    }
    
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
