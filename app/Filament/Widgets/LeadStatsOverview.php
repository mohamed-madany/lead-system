<?php

namespace App\Filament\Widgets;

use App\Domain\Lead\Models\Lead;
use App\Domain\Lead\Enums\LeadStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $totalLeads = Lead::count();
        $newLeads = Lead::where('status', LeadStatus::NEW)->count();
        $qualifiedLeads = Lead::where('status', LeadStatus::QUALIFIED)->count();
        $wonLeads = Lead::where('status', LeadStatus::WON)->count();
        $avgScore = round(Lead::avg('score') ?? 0);
        
        // Calculate conversion rate
        $conversionRate = $totalLeads > 0 ? round(($wonLeads / $totalLeads) * 100, 1) : 0;
        
        // Get trends (last 7 days vs previous 7 days)
        $last7Days = Lead::where('created_at', '>=', now()->subDays(7))->count();
        $previous7Days = Lead::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $trend = $previous7Days > 0 ? round((($last7Days - $previous7Days) / $previous7Days) * 100) : 0;
        
        return [
            Stat::make('إجمالي العملاء', $totalLeads)
                ->description($trend >= 0 ? "زيادة بنسبة {$trend}%" : "انخفاض بنسبة " . abs($trend) . "%")
                ->descriptionIcon($trend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($trend >= 0 ? 'success' : 'danger')
                ->chart(array_fill(0, 7, rand(10, 50))),
            
            Stat::make('عملاء جدد', $newLeads)
                ->description('لم يتم التواصل معهم')
                ->descriptionIcon('heroicon-o-user-plus')
                ->color('primary'),
            
            Stat::make('عملاء مؤهلون', $qualifiedLeads)
                ->description('جاهزون لمرحلة المبيعات')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('info'),
            
            Stat::make('صفقات ناجحة', $wonLeads)
                ->description("معدل تحويل {$conversionRate}%")
                ->descriptionIcon('heroicon-o-trophy')
                ->color('success'),
            
            Stat::make('متوسط النقاط', $avgScore . '/100')
                ->description('مؤشر جودة العملاء')
                ->descriptionIcon('heroicon-o-star')
                ->color($avgScore >= 70 ? 'success' : ($avgScore >= 40 ? 'warning' : 'danger')),
        ];
    }
}
