<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $admin  = Role::firstOrCreate(['name' => 'admin']);
        $vendor = Role::firstOrCreate(['name' => 'vendor']);
        $customer   = Role::firstOrCreate(['name' => 'customer']);

        // Assign permissions (use existing permissions seeded earlier)
        $admin->givePermissionTo(Permission::all());

        $vendor->givePermissionTo([
            'view posts',
            'create posts',
            'edit posts',
        ]);

        $customer->givePermissionTo([
            'view users',
            'view posts',
        ]);
    }
}
