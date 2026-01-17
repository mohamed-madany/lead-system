<?php

namespace App\Filament\SuperAdmin\Resources\Tenants\Schemas;

use App\Models\Tenant;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TenantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('domain')
                    ->placeholder('-'),
                TextEntry::make('slug'),
                TextEntry::make('plan.name')
                    ->label('Plan'),
                TextEntry::make('status'),
                TextEntry::make('trial_ends_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('facebook_page_id')
                    ->placeholder('-'),
                TextEntry::make('whatsapp_phone_number_id')
                    ->placeholder('-'),
                TextEntry::make('settings')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Tenant $record): bool => $record->trashed()),
            ]);
    }
}
