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
            'name' => 'الباقة الأساسية',
            'price' => 400.00,
            'max_leads' => 100,
            'max_users' => 1,
            'features' => ['إدارة حتى 100 ليد / شهر', 'موظف مبيعات واحد', 'أتمتة فيسبوك وواتساب'],
            'is_active' => true,
        ]);
        
        Plan::updateOrCreate([
            'slug' => 'growth'
        ], [
            'name' => 'باقة النمو',
            'price' => 800.00,
            'max_leads' => 500,
            'max_users' => 5,
            'features' => ['إدارة حتى 500 ليد / شهر', '5 موظفين مبيعات', 'تقييم ذكي للعملاء', 'تقارير أداء'],
            'is_active' => true,
        ]);
        
        Plan::updateOrCreate([
            'slug' => 'pro'
        ], [
            'name' => 'الباقة الاحترافية',
            'price' => 1500.00,
            'max_leads' => 9999,
            'max_users' => 20,
            'features' => ['عملاء غير محدودين', 'فريق حتى 20 موظف', 'دعم مخصص 24/7', 'ربط خارجي (API)'],
            'is_active' => true,
        ]);
        
        $this->command->info('✅ Plans updated to Arabic names and EGP prices.');
    }
}
