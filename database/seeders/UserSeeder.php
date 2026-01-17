<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@leadsystem.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'phone' => '+1 (555) 000-0001',
                'role' => 'admin',
                'is_active' => true,
                'is_platform_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create manager user
        User::firstOrCreate(
            ['email' => 'manager@leadsystem.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'phone' => '+1 (555) 000-0002',
                'role' => 'manager',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create regular user
        User::firstOrCreate(
            ['email' => 'sales@leadsystem.com'],
            [
                'name' => 'Sales Rep',
                'password' => Hash::make('password'),
                'phone' => '+1 (555) 000-0003',
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Created 3 test users:');
        $this->command->info('   Admin: admin@leadsystem.com / password');
        $this->command->info('   Manager: manager@leadsystem.com / password');
        $this->command->info('   Sales: sales@leadsystem.com / password');
    }
}
