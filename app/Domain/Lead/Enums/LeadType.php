<?php

namespace App\Domain\Lead\Enums;

enum LeadType: string
{
    case COLD = 'cold';
    case WARM = 'warm';
    case HOT = 'hot';
    case CUSTOMER = 'customer';
    
    public function label(): string
    {
        return match($this) {
            self::COLD => 'Cold Lead',
            self::WARM => 'Warm Lead',
            self::HOT => 'Hot Lead',
            self::CUSTOMER => 'Existing Customer',
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
