<?php

namespace App\Domain\Lead\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum LeadStatus: string implements HasColor, HasLabel
{
    case NEW = 'new';
    case CONTACTED = 'contacted';
    case QUALIFIED = 'qualified';
    case WON = 'won';
    case LOST = 'lost';
    case ARCHIVED = 'archived';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NEW => 'جديد',
            self::CONTACTED => 'تم التواصل',
            self::QUALIFIED => 'عميل مؤهل',
            self::WON => 'عملية ناجحة',
            self::LOST => 'فرصة ضائعة',
            self::ARCHIVED => 'مؤرشف',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::WON => 'success',
            self::QUALIFIED => 'info',
            self::CONTACTED => 'warning',
            self::LOST => 'danger',
            self::ARCHIVED => 'gray',
            self::NEW => 'primary',
        };
    }

    public function isTerminal(): bool
    {
        return in_array($this, [self::WON, self::LOST, self::ARCHIVED]);
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
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
