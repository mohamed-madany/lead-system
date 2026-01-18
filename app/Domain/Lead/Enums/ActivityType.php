<?php

namespace App\Domain\Lead\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ActivityType: string implements HasIcon, HasLabel
{
    case CALL = 'call';
    case EMAIL = 'email';
    case MEETING = 'meeting';
    case NOTE = 'note';
    case STATUS_CHANGE = 'status_change';
    case SCORE_UPDATE = 'score_update';
    case ASSIGNMENT = 'assignment';
    case QUALIFICATION = 'qualification';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CALL => 'مكالمة هاتفية',
            self::EMAIL => 'بريد إلكتروني',
            self::MEETING => 'اجتماع',
            self::NOTE => 'ملحوظة',
            self::STATUS_CHANGE => 'تغيير الحالة',
            self::SCORE_UPDATE => 'تحديث النقاط',
            self::ASSIGNMENT => 'تعيين موظف',
            self::QUALIFICATION => 'تأهيل العميل',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::CALL => 'heroicon-o-phone',
            self::EMAIL => 'heroicon-o-envelope',
            self::MEETING => 'heroicon-o-calendar',
            self::NOTE => 'heroicon-o-document-text',
            self::STATUS_CHANGE => 'heroicon-o-arrow-path',
            self::SCORE_UPDATE => 'heroicon-o-star',
            self::ASSIGNMENT => 'heroicon-o-user',
            self::QUALIFICATION => 'heroicon-o-check-badge',
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
