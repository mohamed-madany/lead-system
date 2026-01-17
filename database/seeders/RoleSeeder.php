<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'view any leads',
            'view leads',
            'create leads',
            'update leads',
            'delete leads',
            'assign leads',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $salesRole = Role::firstOrCreate(['name' => 'sales']);

        // Assign Permissions
        $adminRole->givePermissionTo(Permission::all());
        $managerRole->givePermissionTo(['view any leads', 'view leads', 'create leads', 'update leads', 'assign leads']);
        $salesRole->givePermissionTo(['view leads', 'create leads', 'update leads']);

        // Assign to existing users based on 'role' column
        User::where('role', 'admin')->get()->each(fn ($u) => $u->assignRole($adminRole));
        User::where('role', 'manager')->get()->each(fn ($u) => $u->assignRole($managerRole));
        User::where('role', 'user')->get()->each(fn ($u) => $u->assignRole($salesRole));

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
