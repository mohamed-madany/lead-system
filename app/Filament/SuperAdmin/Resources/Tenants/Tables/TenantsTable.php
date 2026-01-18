<?php

namespace App\Filament\SuperAdmin\Resources\Tenants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم الشركة')
                    ->searchable(),
                TextColumn::make('domain')
                    ->label('النطاق')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('المعرف')
                    ->searchable(),
                TextColumn::make('plan.name')
                    ->label('الباقة')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->searchable(),
                TextColumn::make('trial_ends_at')
                    ->label('نهاية التجربة')
                    ->date()
                    ->sortable(),
                TextColumn::make('facebook_page_id')
                    ->label('صفحة فيسبوك')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('whatsapp_phone_number_id')
                    ->label('رقم واتساب')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('تاريخ الحذف')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()->label('المهملات'),
            ])
            ->recordActions([
                ViewAction::make()->label('عرض'),
                EditAction::make()->label('تعديل'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('حذف'),
                    ForceDeleteBulkAction::make()->label('حذف نهائي'),
                    RestoreBulkAction::make()->label('استعادة'),
                ])->label('عمليات بالجملة'),
            ]);
    }
}
