<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LeadSeeder::class,
        ]);
        
        $this->command->info('');
        $this->command->info('🎉 Database seeded successfully!');
        $this->command->info('📧 You can login with:');
        $this->command->info('   Email: admin@leadsystem.com');
        $this->command->info('   Password: password');
    }
}
