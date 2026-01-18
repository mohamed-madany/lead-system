<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Domain\Lead\Enums\LeadStatus;
use App\Filament\Resources\LeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('إضافة عميل جديد'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('الكل'),

            'new' => Tab::make('عملاء جدد')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeadStatus::NEW))
                ->badge(fn () => \App\Domain\Lead\Models\Lead::where('status', LeadStatus::NEW)->count()),

            'contacted' => Tab::make('تم التواصل')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeadStatus::CONTACTED))
                ->badge(fn () => \App\Domain\Lead\Models\Lead::where('status', LeadStatus::CONTACTED)->count()),

            'qualified' => Tab::make('مؤهلون')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeadStatus::QUALIFIED))
                ->badge(fn () => \App\Domain\Lead\Models\Lead::where('status', LeadStatus::QUALIFIED)->count()),

            'won' => Tab::make('ناجحة')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeadStatus::WON))
                ->badge(fn () => \App\Domain\Lead\Models\Lead::where('status', LeadStatus::WON)->count()),

            'high_score' => Tab::make('جودة عالية')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('score', '>=', 70))
                ->badge(fn () => \App\Domain\Lead\Models\Lead::where('score', '>=', 70)->count()),
        ];
    }
}
