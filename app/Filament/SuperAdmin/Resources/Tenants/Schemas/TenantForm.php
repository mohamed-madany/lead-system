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
                    ->label('اسم الشركة')
                    ->required(),
                TextInput::make('domain')
                    ->label('النطاق (Domain)')
                    ->default(null),
                TextInput::make('slug')
                    ->label('المعرف الرابط (Slug)')
                    ->required(),
                Select::make('plan_id')
                    ->label('باقة الاشتراك')
                    ->relationship('plan', 'name')
                    ->required(),
                TextInput::make('status')
                    ->label('الحالة')
                    ->required()
                    ->default('active'),
                DatePicker::make('trial_ends_at')
                    ->label('تاريخ انتهاء الفترة التجريبية'),
                TextInput::make('facebook_page_id')
                    ->label('معرف صفحة فيسبوك')
                    ->default(null),
                TextInput::make('whatsapp_phone_number_id')
                    ->label('معرف واتساب')
                    ->tel()
                    ->default(null),
                Textarea::make('settings')
                    ->label('الإعدادات الإضافية (JSON)')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
