<?php

namespace App\Domain\Lead\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum QualityRating: string implements HasLabel, HasColor
{
    case POOR = 'poor';
    case FAIR = 'fair';
    case GOOD = 'good';
    case EXCELLENT = 'excellent';
    
    public function getLabel(): ?string
    {
        return match($this) {
            self::POOR => 'جودة ضعيفة',
            self::FAIR => 'جودة متوسطة',
            self::GOOD => 'جودة جيدة',
            self::EXCELLENT => 'جودة ممتازة',
        };
    }

    public function getColor(): string | array | null
    {
        return match($this) {
            self::POOR => 'danger',
            self::FAIR => 'warning',
            self::GOOD => 'info',
            self::EXCELLENT => 'success',
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
