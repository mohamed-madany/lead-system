<?php

namespace App\Domain\Lead\Enums;

use Filament\Support\Contracts\HasLabel;

enum LeadType: string implements HasLabel
{
    case COLD = 'cold';
    case WARM = 'warm';
    case HOT = 'hot';
    case CUSTOMER = 'customer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::COLD => 'عميل بارد',
            self::WARM => 'عميل مهتم',
            self::HOT => 'عميل ساخن',
            self::CUSTOMER => 'عميل سابق',
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
