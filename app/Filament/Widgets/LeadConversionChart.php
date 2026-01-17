<?php

namespace App\Filament\Widgets;

use App\Domain\Lead\Enums\LeadStatus;
use App\Domain\Lead\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadConversionChart extends ChartWidget
{
    protected ?string $heading = 'Lead Conversion Funnel';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $total = Lead::count();
        $qualified = Lead::where('status', LeadStatus::QUALIFIED)->count();
        $won = Lead::where('status', LeadStatus::WON)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => [$total, $qualified, $won],
                    'backgroundColor' => [
                        '#9ca3af', // Gray for Total
                        '#fbbf24', // Amber for Qualified
                        '#22c55e', // Green for Won
                    ],
                ],
            ],
            'labels' => ['Total Leads', 'Qualified', 'Won Deals'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
