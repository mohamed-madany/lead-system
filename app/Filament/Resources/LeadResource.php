<?php

namespace App\Filament\Resources;

use App\Domain\Lead\Enums\LeadSource;
use App\Domain\Lead\Enums\LeadStatus;
use App\Domain\Lead\Enums\LeadType;
use App\Domain\Lead\Enums\QualityRating;
use App\Domain\Lead\Models\Lead;
use App\Filament\Resources\LeadResource\Pages;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LeadResource extends Resource
{
    public static function getModel(): string
    {
        return Lead::class;
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-user-group';
    }

    public static function getNavigationLabel(): string
    {
        return 'العملاء المهتمين';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return 'name';
    }

    public static function getPluralLabel(): ?string
    {
        return 'العملاء المهتمين';
    }

    public static function getModelLabel(): string
    {
        return 'عميل';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('البيانات الشخصية')
                ->description('بيانات التواصل الأساسية للعميل')
                ->components([
                    \Filament\Forms\Components\TextInput::make('name')
                        ->label('الاسم الكامل')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('أدخل اسم العميل بالكامل')
                        ->columnSpan(2),

                    \Filament\Forms\Components\TextInput::make('email')
                        ->label('البريد الإلكتروني')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->placeholder('example@mail.com')
                        ->suffixIcon('heroicon-o-envelope'),

                    \Filament\Forms\Components\TextInput::make('phone')
                        ->label('رقم الهاتف')
                        ->tel()
                        ->required()
                        ->maxLength(50)
                        ->placeholder('01xxxxxxxxx')
                        ->suffixIcon('heroicon-o-phone'),

                    \Filament\Forms\Components\TextInput::make('company_name')
                        ->label('اسم الشركة')
                        ->maxLength(255)
                        ->placeholder('اختياري')
                        ->suffixIcon('heroicon-o-building-office'),

                    \Filament\Forms\Components\TextInput::make('job_title')
                        ->label('المسمى الوظيفي')
                        ->maxLength(255)
                        ->placeholder('اختياري')
                        ->suffixIcon('heroicon-o-briefcase'),
                ])
                ->columns(2)
                ->collapsible(),

            \Filament\Schemas\Components\Section::make('تصنيف العميل')
                ->description('الحالة، المصدر، وتقييم جودة العميل')
                ->components([
                    \Filament\Forms\Components\Select::make('status')
                        ->label('حالة العميل')
                        ->options(LeadStatus::class)
                        ->default(LeadStatus::NEW)
                        ->required()
                        ->native(false),

                    \Filament\Forms\Components\Select::make('source')
                        ->label('مصدر العميل')
                        ->options(LeadSource::class)
                        ->default(LeadSource::MANUAL)
                        ->required()
                        ->native(false),

                    \Filament\Forms\Components\Select::make('lead_type')
                        ->label('نوع العميل')
                        ->options(LeadType::class)
                        ->default(LeadType::COLD)
                        ->native(false),

                    \Filament\Forms\Components\Select::make('quality_rating')
                        ->label('تقييم الجودة')
                        ->options(QualityRating::class)
                        ->default(QualityRating::FAIR)
                        ->native(false),

                    \Filament\Forms\Components\TextInput::make('score')
                        ->label('النقاط (Score)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(0)
                        ->suffix('نقطة')
                        ->helperText('تقييم العميل من 0 إلى 100'),

                    \Filament\Forms\Components\TextInput::make('probability_percentage')
                        ->label('احتمالية الإغلاق')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(0)
                        ->suffix('%'),
                ])
                ->columns(3)
                ->collapsible(),

            \Filament\Schemas\Components\Section::make('المسؤول والقيمة المتوقعة')
                ->components([
                    \Filament\Forms\Components\Select::make('assigned_to')
                        ->label('تعيين للموظف')
                        ->relationship('assignedUser', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('غير معين')
                        ->native(false)
                        ->disabled(fn () => ! auth()->user()->hasRole(['admin', 'manager'])),

                    \Filament\Forms\Components\TextInput::make('estimated_value')
                        ->label('القيمة التقديرية')
                        ->numeric()
                        ->prefix('ج.م')
                        ->step('1')
                        ->placeholder('0.00'),
                ])
                ->columns(2)
                ->collapsible(),

            \Filament\Schemas\Components\Section::make('ملاحظات وتفاصيل إضافية')
                ->components([
                    \Filament\Forms\Components\Textarea::make('notes')
                        ->label('ملاحظات العميل')
                        ->rows(3)
                        ->maxLength(2000)
                        ->placeholder('أي ملاحظات ذكرها العميل')
                        ->columnSpan(2),

                    \Filament\Forms\Components\Textarea::make('internal_comments')
                        ->label('تعليقات داخلية')
                        ->rows(3)
                        ->maxLength(2000)
                        ->placeholder('ملاحظات الموظفين (لا تراها العميل)')
                        ->columnSpan(2),
                ])
                ->columns(2)
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Lead $record): ?string => $record->company_name),

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone'),

                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('score')
                    ->label('النقاط')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 90 => 'success',
                        $state >= 70 => 'info',
                        $state >= 40 => 'warning',
                        default => 'danger',
                    })
                    ->suffix(' نقطة')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('source')
                    ->label('المصدر')
                    ->badge()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('الموظف المسؤول')
                    ->default('غير معين')
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(LeadStatus::class)
                    ->multiple(),

                Tables\Filters\SelectFilter::make('source')
                    ->label('المصدر')
                    ->options(LeadSource::class)
                    ->multiple(),

                Tables\Filters\SelectFilter::make('lead_type')
                    ->label('نوع العميل')
                    ->options(LeadType::class)
                    ->multiple(),

                Tables\Filters\SelectFilter::make('assigned_to')
                    ->label('الموظف المسؤول')
                    ->relationship('assignedUser', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('high_score')
                    ->label('العملاء ذوي الجودة العالية (70+)')
                    ->query(fn (Builder $query) => $query->where('score', '>=', 70))
                    ->toggle(),

                Tables\Filters\Filter::make('unassigned')
                    ->label('عملاء غير معينين')
                    ->query(fn (Builder $query) => $query->whereNull('assigned_to'))
                    ->toggle(),

                Tables\Filters\Filter::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('من تاريخ'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->label('عرض'),
                    EditAction::make()->label('تعديل'),
                    DeleteAction::make()->label('حذف'),
                ])->label('خيارات'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('حذف المحدد'),
                ])->label('عمليات بالجملة'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'view' => Pages\ViewLead::route('/{record}'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
