<?php

namespace App\Domain\Lead\Enums;

enum QualityRating: string
{
    case POOR = 'poor';
    case FAIR = 'fair';
    case GOOD = 'good';
    case EXCELLENT = 'excellent';
    
    public function label(): string
    {
        return match($this) {
            self::POOR => 'Poor Quality',
            self::FAIR => 'Fair Quality',
            self::GOOD => 'Good Quality',
            self::EXCELLENT => 'Excellent Quality',
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
