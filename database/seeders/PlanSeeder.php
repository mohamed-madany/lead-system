<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder 
{
    public function run() 
    {
        Plan::updateOrCreate([
            'slug' => 'starter'
        ], [
            'name' => 'باقة البداية',
            'price' => 1500.00,
            'max_leads' => 150,
            'max_users' => 1,
            'features' => ['إدارة حتى 150 عميل / شهر', 'موظف مبيعات واحد', 'ربط فيسبوك وواتساب'],
            'is_active' => true,
        ]);
        
        Plan::updateOrCreate([
            'slug' => 'growth'
        ], [
            'name' => 'باقة النمو',
            'price' => 3000.00,
            'max_leads' => 750,
            'max_users' => 5,
            'features' => ['إدارة حتى 750 عميل / شهر', '5 موظفين مبيعات', 'نظام التقييم والفلترة الذكي', 'تقارير أداء تفصيلية'],
            'is_active' => true,
        ]);
        
        Plan::updateOrCreate([
            'slug' => 'pro'
        ], [
            'name' => 'الباقة الاحترافية',
            'price' => 6000.00,
            'max_leads' => 999999,
            'max_users' => 100,
            'features' => ['عملاء مهتمين غير محدودين', 'فريق غير محدود', 'دعم فني VIP مخصص', 'ربط API وتطوير مخصص'],
            'is_active' => true,
        ]);
        
        $this->command->info('✅ Plans updated to Arabic names and EGP prices.');
    }
}
