<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder 
{
    public function run() 
    {
        Plan::firstOrCreate([
            'slug' => 'starter'
        ], [
            'name' => 'Starter',
            'price' => 49.00,
            'max_leads' => 100,
            'max_users' => 1,
            'features' => ['basic_support', 'web_form']
        ]);
        
        Plan::firstOrCreate([
            'slug' => 'growth'
        ], [
            'name' => 'Growth',
            'price' => 99.00,
            'max_leads' => 500,
            'max_users' => 5,
            'features' => ['priority_support', 'web_form', 'webhooks']
        ]);
        
        Plan::firstOrCreate([
            'slug' => 'pro'
        ], [
            'name' => 'Professional',
            'price' => 199.00,
            'max_leads' => 99999,
            'max_users' => 10,
            'features' => ['dedicated_support', 'web_form', 'webhooks', 'api_access']
        ]);
        
        $this->command->info('✅ Plans seeded successfully.');
    }
}
