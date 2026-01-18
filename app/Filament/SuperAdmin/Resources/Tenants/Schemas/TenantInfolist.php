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
                TextEntry::make('name')->label('اسم الشركة'),
                TextEntry::make('domain')
                    ->label('النطاق')
                    ->placeholder('-'),
                TextEntry::make('slug')->label('المعرف الرابط'),
                TextEntry::make('plan.name')
                    ->label('باقة الاشتراك'),
                TextEntry::make('status')->label('الحالة'),
                TextEntry::make('trial_ends_at')
                    ->label('نهاية التجربة')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('facebook_page_id')
                    ->label('معرف صفحة فيسبوك')
                    ->placeholder('-'),
                TextEntry::make('whatsapp_phone_number_id')
                    ->label('معرف واتساب')
                    ->placeholder('-'),
                TextEntry::make('settings')
                    ->label('الإعدادات')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->label('تاريخ الحذف')
                    ->dateTime()
                    ->visible(fn (Tenant $record): bool => $record->trashed()),
            ]);
    }
}
