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
        // سكرتير النظام (أدمن اللوحة العليا)
        User::firstOrCreate(
            ['email' => 'admin@leadsfiy.com'],
            [
                'name' => 'مدير النظام الرئيسي',
                'password' => Hash::make('password123'),
                'phone' => '01000000001',
                'role' => 'admin',
                'is_active' => true,
                'is_platform_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // مدير مبيعات
        User::firstOrCreate(
            ['email' => 'manager@leadsystem.com'],
            [
                'name' => 'مدير مبيعات',
                'password' => Hash::make('password'),
                'phone' => '01000000002',
                'role' => 'manager',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // مندوب مبيعات
        User::firstOrCreate(
            ['email' => 'sales@leadsystem.com'],
            [
                'name' => 'مندوب مبيعات',
                'password' => Hash::make('password'),
                'phone' => '01000000003',
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ تم إنشاء 3 مستخدمين تجريبيين بنجاح.');
    }
}
