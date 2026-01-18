<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Tenant;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PlatformRevenueChart extends ChartWidget
{
    protected ?string $heading = 'نمو الشركات المشتركة';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // For now, let's show tenant registration growth as a proxy for platform performance
        $data = Tenant::select(
            DB::raw('count(*) as count'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'الشركات الجديدة',
                    'data' => $data->pluck('count')->toArray(),
                    'fill' => 'start',
                    'tension' => 0.4,
                    'backgroundColor' => 'rgba(0, 86, 148, 0.1)',
                    'borderColor' => '#005694',
                ],
            ],
            'labels' => $data->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
