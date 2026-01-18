<?php

namespace App\Filament\SuperAdmin\Resources\Plans;

use App\Filament\SuperAdmin\Resources\Plans\Pages\ManagePlans;
use App\Models\Plan;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'باقات الاشتراك';

    protected static ?string $pluralLabel = 'باقات الاشتراك';

    protected static ?string $modelLabel = 'باقة';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم الباقة')
                    ->required(),
                TextInput::make('slug')
                    ->label('المعرف الرابط (Slug)')
                    ->required(),
                TextInput::make('price')
                    ->label('السعر')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                TextInput::make('max_leads')
                    ->label('الحد الأقصى للعملاء')
                    ->required()
                    ->numeric()
                    ->default(100),
                TextInput::make('max_users')
                    ->label('الحد الأقصى للمستخدمين')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('features')
                    ->label('المميزات')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label('اسم الباقة'),
                TextEntry::make('slug')->label('المعرف الرابط'),
                TextEntry::make('price')
                    ->label('السعر')
                    ->money(),
                TextEntry::make('max_leads')
                    ->label('حد العملاء')
                    ->numeric(),
                TextEntry::make('max_users')
                    ->label('حد المستخدمين')
                    ->numeric(),
                TextEntry::make('features')
                    ->label('المميزات')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('اسم الباقة')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('المعرف')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('السعر')
                    ->money()
                    ->sortable(),
                TextColumn::make('max_leads')
                    ->label('العملاء')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_users')
                    ->label('المستخدمين')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('أنشئ في')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('حدث في')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->label('عرض'),
                EditAction::make()->label('تعديل'),
                DeleteAction::make()->label('حذف'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->label('عمليات بالجملة'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePlans::route('/'),
        ];
    }
}
