<?php

namespace App\Filament\SuperAdmin\Resources\Tenants\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('domain')
                    ->default(null),
                TextInput::make('slug')
                    ->required(),
                Select::make('plan_id')
                    ->relationship('plan', 'name')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                DatePicker::make('trial_ends_at'),
                TextInput::make('facebook_page_id')
                    ->default(null),
                TextInput::make('whatsapp_phone_number_id')
                    ->tel()
                    ->default(null),
                Textarea::make('settings')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
