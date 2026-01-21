<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // Create Demo Tenant: CUDAL-BLANCO DENTAL CLINIC
        $tenant1 = Tenant::create([
            'name' => 'CUDAL-BLANCO DENTAL CLINIC',
            'slug' => 'cudalblanco',
            'subscription_plan' => 'pro',
            'subscription_status' => 'active',
            'subscription_ends_at' => now()->addYear(),
            'max_users' => 20,
            'max_patients' => 1000,
            'features' => ['advanced_analytics', 'sms_reminders', 'online_booking'],
            'settings' => [
                'working_hours' => '8:00 AM - 6:00 PM',
                'timezone' => 'Asia/Manila',
            ],
            'branding' => [
                'primary_color' => '#667eea',
                'secondary_color' => '#764ba2',
            ],
            'is_active' => true,
            'contact_email' => 'info@cudalblanco.com',
            'contact_phone' => '09123456789',
            'city' => 'Manila',
            'country' => 'Philippines',
        ]);

        // Create roles for this tenant
        $this->createTenantRoles($tenant1);

        // Create Demo Tenant 2: City Dental Care
        $tenant2 = Tenant::create([
            'name' => 'City Dental Care',
            'slug' => 'citydentalcare',
            'subscription_plan' => 'basic',
            'subscription_status' => 'trial',
            'trial_ends_at' => now()->addDays(14),
            'max_users' => 5,
            'max_patients' => 100,
            'features' => [],
            'is_active' => true,
            'contact_email' => 'info@citydentalcare.com',
            'city' => 'Quezon City',
            'country' => 'Philippines',
        ]);

        $this->createTenantRoles($tenant2);
    }

    protected function createTenantRoles(Tenant $tenant): void
    {
        // Clinic Admin Role
        $clinicAdmin = Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Clinic Admin',
            'slug' => 'clinic_admin',
            'description' => 'Full access within the clinic',
            'is_system_role' => true,
        ]);
        $clinicAdmin->permissions()->attach(Permission::all());

        // Dentist Role
        $dentist = Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Dentist',
            'slug' => 'dentist',
            'description' => 'Can manage patients, appointments, and dental records',
            'is_system_role' => true,
        ]);
        $dentist->permissions()->attach(
            Permission::whereIn('slug', [
                'patients.view', 'patients.create', 'patients.edit',
                'appointments.view_own', 'appointments.create', 'appointments.edit',
                'dental_records.view', 'dental_records.create', 'dental_records.edit',
                'treatments.view', 'treatments.create', 'treatments.edit', 'treatments.complete',
                'invoices.view', 'invoices.create',
                'reports.view_own',
            ])->pluck('id')
        );

        // Receptionist Role
        $receptionist = Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Receptionist',
            'slug' => 'receptionist',
            'description' => 'Can manage appointments, patients, and billing',
            'is_system_role' => true,
        ]);
        $receptionist->permissions()->attach(
            Permission::whereIn('slug', [
                'patients.view', 'patients.create', 'patients.edit',
                'appointments.view_all', 'appointments.create', 'appointments.edit', 'appointments.cancel',
                'invoices.view', 'invoices.create', 'invoices.edit',
                'payments.create',
            ])->pluck('id')
        );

        // Create users for tenant (only for first tenant)
        if ($tenant->slug === 'cudalblanco') {
            User::create([
                'tenant_id' => $tenant->id,
                'role_id' => $clinicAdmin->id,
                'name' => 'Admin User',
                'email' => 'admin@cudalblanco.com',
                'password' => Hash::make('Joenil@20'),
                'phone' => '09123456789',
                'is_active' => true,
            ]);

            User::create([
                'tenant_id' => $tenant->id,
                'role_id' => $dentist->id,
                'name' => 'Dr. Juan Cudal',
                'email' => 'dentist@cudalblanco.com',
                'password' => Hash::make('Joenil@20'),
                'phone' => '09123456780',
                'license_number' => 'DDS-12345',
                'specialization' => 'General Dentistry',
                'is_active' => true,
            ]);

            User::create([
                'tenant_id' => $tenant->id,
                'role_id' => $receptionist->id,
                'name' => 'Maria Receptionist',
                'email' => 'receptionist@cudalblanco.com',
                'password' => Hash::make('Joenil@20'),
                'phone' => '09123456781',
                'is_active' => true,
            ]);
        }
    }
}
