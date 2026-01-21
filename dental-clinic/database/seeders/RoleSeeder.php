<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin (Platform Level - no tenant)
        $superAdmin = Role::create([
            'tenant_id' => null,
            'name' => 'Super Admin',
            'slug' => 'super_admin',
            'description' => 'Platform administrator with full access',
            'is_system_role' => true,
        ]);
        $superAdmin->permissions()->attach(Permission::all());

        // Create Super Admin User
        \App\Models\User::create([
            'tenant_id' => null,
            'role_id' => $superAdmin->id,
            'name' => 'Super Admin',
            'email' => 'superadmin@dentalapp.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Joenil@20'),
            'phone' => '09999999999',
            'is_active' => true,
        ]);

        // Note: Tenant-specific roles will be created when tenants are seeded
        // This seeder only creates the super admin platform role
    }
}
