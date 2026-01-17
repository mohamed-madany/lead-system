<?php

namespace App\Domain\Lead\Enums;

enum LeadStatus: string
{
    case NEW = 'new';
    case CONTACTED = 'contacted';
    case QUALIFIED = 'qualified';
    case WON = 'won';
    case LOST = 'lost';
    case ARCHIVED = 'archived';
    
    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match($this) {
            self::NEW => 'New Lead',
            self::CONTACTED => 'Contacted',
            self::QUALIFIED => 'Qualified',
            self::WON => 'Won Deal',
            self::LOST => 'Lost Opportunity',
            self::ARCHIVED => 'Archived',
        };
    }
    
    /**
     * Get color for UI display
     */
    public function color(): string
    {
        return match($this) {
            self::WON => 'success',
            self::QUALIFIED => 'info',
            self::CONTACTED => 'warning',
            self::LOST => 'danger',
            self::ARCHIVED => 'secondary',
            self::NEW => 'primary',
        };
    }


    /**
     * Check if status is terminal (cannot be changed)
     */
    public function isTerminal(): bool
    {
        return in_array($this, [self::WON, self::LOST, self::ARCHIVED]);
    }
    
    /**
     * Get all statuses as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    /**
     * Get all statuses for select options
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
