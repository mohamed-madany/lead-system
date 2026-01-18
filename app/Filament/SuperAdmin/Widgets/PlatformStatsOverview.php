<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Tenant;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlatformStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalTenants = Tenant::count();
        $totalUsers = User::count();
        $activeTenants = Tenant::where('status', 'active')->count();

        // Calculate some basic trends
        $newTenantsThisMonth = Tenant::where('created_at', '>=', now()->startOfMonth())->count();

        return [
            Stat::make('إجمالي الشركات', $totalTenants)
                ->description('نمو مستمر للمنصة')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary')
                ->chart([7, 10, 5, 2, 21, 32, 45]),

            Stat::make('شركات نشطة', $activeTenants)
                ->description('اشتراكات فعالة حالياً')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('إجمالي المستخدمين', $totalUsers)
                ->description('مدراء وموظفين')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('شركات جديدة (هذا الشهر)', $newTenantsThisMonth)
                ->description('معدل نمو المنصة')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}
