<?php

namespace App\Domain\Lead\Enums;

enum ActivityType: string
{
    case CALL = 'call';
    case EMAIL = 'email';
    case MEETING = 'meeting';
    case NOTE = 'note';
    case STATUS_CHANGE = 'status_change';
    case SCORE_UPDATE = 'score_update';
    case ASSIGNMENT = 'assignment';
    case QUALIFICATION = 'qualification';
    
    public function label(): string
    {
        return match($this) {
            self::CALL => 'Phone Call',
            self::EMAIL => 'Email',
            self::MEETING => 'Meeting',
            self::NOTE => 'Note',
            self::STATUS_CHANGE => 'Status Change',
            self::SCORE_UPDATE => 'Score Update',
            self::ASSIGNMENT => 'Assignment',
            self::QUALIFICATION => 'Qualification',
        };
    }
    
    public function icon(): string
    {
        return match($this) {
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
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
