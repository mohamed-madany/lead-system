<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use App\Domain\Lead\Models\Lead;

class DefaultTenantSeeder extends Seeder 
{
    public function run() 
    {
        // 1. Create Default Tenant
        $tenant = Tenant::firstOrCreate([
            'slug' => 'default'
        ], [
            'name' => 'Default Organization',
            'domain' => 'app.localhost',
            'plan_id' => 1, // Starter
            'status' => 'active'
        ]);
        
        // 2. Assign all Users to this tenant (except Super Admin if we had one, but for now assign all)
        $usersCount = User::whereNull('tenant_id')->update(['tenant_id' => $tenant->id]);
        
        // 3. Assign all Leads to this tenant
        // Use withoutGlobalScopes just in case
        $leadsCount = Lead::withoutGlobalScopes()->whereNull('tenant_id')->update(['tenant_id' => $tenant->id]);
        
        $this->command->info("✅ assigned {$usersCount} users and {$leadsCount} leads to '{$tenant->name}'");
    }
}
