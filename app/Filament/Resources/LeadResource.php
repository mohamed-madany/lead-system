<?php

namespace App\Filament\Resources;

use App\Domain\Lead\Enums\LeadSource;
use App\Domain\Lead\Enums\LeadStatus;
use App\Domain\Lead\Enums\LeadType;
use App\Domain\Lead\Enums\QualityRating;
use App\Domain\Lead\Models\Lead;
use App\Filament\Resources\LeadResource\Pages;
use Filament\Forms;
use Filament\Notifications\Notification;
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
        return 'Leads';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return 'name';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Contact Information')
                ->description('Lead contact details')
                ->components([
                    \Filament\Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Full name')
                        ->columnSpan(2),

                    \Filament\Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->placeholder('email@example.com')
                        ->suffixIcon('heroicon-o-envelope'),

                    \Filament\Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->required()
                        ->maxLength(50)
                        ->placeholder('+1 (555) 000-0000')
                        ->suffixIcon('heroicon-o-phone'),

                    \Filament\Forms\Components\TextInput::make('company_name')
                        ->maxLength(255)
                        ->placeholder('Company name')
                        ->suffixIcon('heroicon-o-building-office'),

                    \Filament\Forms\Components\TextInput::make('job_title')
                        ->maxLength(255)
                        ->placeholder('Job title')
                        ->suffixIcon('heroicon-o-briefcase'),
                ])
                ->columns(2)
                ->collapsible(),

            \Filament\Schemas\Components\Section::make('Lead Classification')
                ->description('Status, source, and scoring information')
                ->components([
                    \Filament\Forms\Components\Select::make('status')
                        ->options(LeadStatus::options())
                        ->default('new')
                        ->required()
                        ->native(false),

                    \Filament\Forms\Components\Select::make('source')
                        ->options(LeadSource::options())
                        ->default('form')
                        ->required()
                        ->native(false),

                    \Filament\Forms\Components\Select::make('lead_type')
                        ->label('Lead Type')
                        ->options(LeadType::options())
                        ->default('cold')
                        ->native(false),

                    \Filament\Forms\Components\Select::make('quality_rating')
                        ->label('Quality Rating')
                        ->options(QualityRating::options())
                        ->default('fair')
                        ->native(false),

                    \Filament\Forms\Components\TextInput::make('score')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(0)
                        ->suffix('points')
                        ->helperText('Lead score (0-100)'),

                    \Filament\Forms\Components\TextInput::make('probability_percentage')
                        ->label('Win Probability')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(0)
                        ->suffix('%'),
                ])
                ->columns(3)
                ->collapsible(),

            \Filament\Schemas\Components\Section::make('Assignment & Value')
                ->components([
                    \Filament\Forms\Components\Select::make('assigned_to')
                        ->label('Assigned To')
                        ->relationship('assignedUser', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('Unassigned')
                        ->native(false)
                        ->disabled(fn () => ! auth()->user()->hasRole(['admin', 'manager'])),

                    \Filament\Forms\Components\TextInput::make('estimated_value')
                        ->label('Estimated Value')
                        ->numeric()
                        ->prefix('$')
                        ->step('0.01')
                        ->placeholder('0.00'),
                ])
                ->columns(2)
                ->collapsible(),

            \Filament\Schemas\Components\Section::make('Notes & Comments')
                ->components([
                    \Filament\Forms\Components\Textarea::make('notes')
                        ->label('Public Notes')
                        ->rows(3)
                        ->maxLength(2000)
                        ->placeholder('Notes visible to the lead')
                        ->columnSpan(2),

                    \Filament\Forms\Components\Textarea::make('internal_comments')
                        ->label('Internal Comments')
                        ->rows(3)
                        ->maxLength(2000)
                        ->placeholder('Internal notes (not visible to lead)')
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
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Lead $record): ?string => $record->company_name),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope')
                    ->iconColor('primary')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone')
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->formatStateUsing(fn (LeadStatus $state) => $state->label())
                    ->colors([
                        'success' => fn (LeadStatus $state) => $state === LeadStatus::WON,
                        'info' => fn (LeadStatus $state) => $state === LeadStatus::QUALIFIED,
                        'warning' => fn (LeadStatus $state) => $state === LeadStatus::CONTACTED,
                        'danger' => fn (LeadStatus $state) => $state === LeadStatus::LOST,
                        'gray' => fn (LeadStatus $state) => $state === LeadStatus::ARCHIVED,
                        'primary' => fn (LeadStatus $state) => $state === LeadStatus::NEW,
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 90 => 'success',
                        $state >= 70 => 'info',
                        $state >= 40 => 'warning',
                        default => 'danger',
                    })
                    ->suffix(' pts')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('source')
                    ->formatStateUsing(fn (LeadSource $state) => $state->label())
                    ->badge()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned To')
                    ->default('Unassigned')
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('qualified_at')
                    ->label('Qualified')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(LeadStatus::options())
                    ->multiple()
                    ->label('Status'),

                Tables\Filters\SelectFilter::make('source')
                    ->options(LeadSource::options())
                    ->multiple()
                    ->label('Source'),

                Tables\Filters\SelectFilter::make('lead_type')
                    ->options(LeadType::options())
                    ->multiple()
                    ->label('Lead Type'),

                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Assigned To'),

                Tables\Filters\Filter::make('high_score')
                    ->label('High Score (70+)')
                    ->query(fn (Builder $query) => $query->where('score', '>=', 70))
                    ->toggle(),

                Tables\Filters\Filter::make('unassigned')
                    ->label('Unassigned')
                    ->query(fn (Builder $query) => $query->whereNull('assigned_to'))
                    ->toggle(),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created Until'),
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
                \Filament\Actions\ActionGroup::make([
                    \Filament\Actions\ViewAction::make(),
                    \Filament\Actions\EditAction::make(),

                    \Filament\Actions\Action::make('qualify')
                        ->label('Qualify')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Lead $record) {
                            $record->qualify();
                            Notification::make()
                                ->title('Lead qualified successfully')
                                ->success()
                                ->send();
                        })
                        ->visible(fn (Lead $record) => $record->status !== LeadStatus::QUALIFIED),

                    \Filament\Actions\Action::make('markAsWon')
                        ->label('Mark as Won')
                        ->icon('heroicon-o-trophy')
                        ->color('success')
                        ->form([
                            \Filament\Forms\Components\TextInput::make('value')
                                ->label('Deal Value')
                                ->numeric()
                                ->prefix('$')
                                ->required(),
                        ])
                        ->action(function (Lead $record, array $data) {
                            $record->markAsWon($data['value']);
                            Notification::make()
                                ->title('Lead marked as won!')
                                ->success()
                                ->send();
                        }),

                    \Filament\Actions\Action::make('markAsLost')
                        ->label('Mark as Lost')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->form([
                            \Filament\Forms\Components\Textarea::make('reason')
                                ->label('Reason for losing')
                                ->required()
                                ->rows(3),
                        ])
                        ->action(function (Lead $record, array $data) {
                            $record->markAsLost($data['reason']);
                            Notification::make()
                                ->title('Lead marked as lost')
                                ->warning()
                                ->send();
                        }),

                    \Filament\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('changeStatus')
                        ->label('Change Status')
                        ->icon('heroicon-o-arrow-path')
                        ->form([
                            \Filament\Forms\Components\Select::make('status')
                                ->label('New Status')
                                ->options(LeadStatus::options())
                                ->required()
                                ->native(false),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data) {
                            $records->each->update(['status' => $data['status']]);

                            Notification::make()
                                ->title('Status updated for '.$records->count().' leads')
                                ->success()
                                ->send();
                        }),

                    \Filament\Actions\BulkAction::make('assignTo')
                        ->label('Assign To User')
                        ->icon('heroicon-o-user')
                        ->form([
                            \Filament\Forms\Components\Select::make('user_id')
                                ->label('Assign To')
                                ->relationship('assignedUser', 'name')
                                ->searchable()
                                ->required()
                                ->native(false),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data) {
                            $records->each->assignTo($data['user_id']);

                            Notification::make()
                                ->title('Assigned '.$records->count().' leads')
                                ->success()
                                ->send();
                        }),

                    \Filament\Actions\DeleteBulkAction::make(),

                    \Filament\Actions\BulkAction::make('export')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            // Export logic here
                            Notification::make()
                                ->title('Export started')
                                ->info()
                                ->send();
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
            'view' => Pages\ViewLead::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', LeadStatus::NEW)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->check() && auth()->user()->hasRole(['admin', 'manager'])) {
            return $query;
        }

        return $query->where('assigned_to', auth()->id());
    }
}
