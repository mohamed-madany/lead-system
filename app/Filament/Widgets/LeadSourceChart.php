<?php

namespace App\Filament\Widgets;

use App\Domain\Lead\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadSourceChart extends ChartWidget
{
    protected ?string $heading = 'Lead Sources Distribution';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $sources = Lead::query()
            ->selectRaw('source, COUNT(*) as count')
            ->groupBy('source')
            ->pluck('count', 'source')
            ->toArray();

        $labels = [];
        $data = [];

        foreach ($sources as $source => $count) {
            // Convert enum value to label
            $sourceEnum = \App\Domain\Lead\Enums\LeadSource::from($source);
            $labels[] = $sourceEnum->label();
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Leads by Source',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',  // Blue
                        'rgb(16, 185, 129)',  // Green
                        'rgb(249, 115, 22)',  // Orange
                        'rgb(168, 85, 247)',  // Purple
                        'rgb(236, 72, 153)',  // Pink
                        'rgb(251, 191, 36)',  // Yellow
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
