<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Patients
            ['name' => 'View Patients', 'slug' => 'patients.view', 'module' => 'patients'],
            ['name' => 'Create Patients', 'slug' => 'patients.create', 'module' => 'patients'],
            ['name' => 'Edit Patients', 'slug' => 'patients.edit', 'module' => 'patients'],
            ['name' => 'Delete Patients', 'slug' => 'patients.delete', 'module' => 'patients'],
            ['name' => 'Export Patients', 'slug' => 'patients.export', 'module' => 'patients'],

            // Appointments
            ['name' => 'View Own Appointments', 'slug' => 'appointments.view_own', 'module' => 'appointments'],
            ['name' => 'View All Appointments', 'slug' => 'appointments.view_all', 'module' => 'appointments'],
            ['name' => 'Create Appointments', 'slug' => 'appointments.create', 'module' => 'appointments'],
            ['name' => 'Edit Appointments', 'slug' => 'appointments.edit', 'module' => 'appointments'],
            ['name' => 'Cancel Appointments', 'slug' => 'appointments.cancel', 'module' => 'appointments'],

            // Dental Records
            ['name' => 'View Dental Records', 'slug' => 'dental_records.view', 'module' => 'dental_records'],
            ['name' => 'Create Dental Records', 'slug' => 'dental_records.create', 'module' => 'dental_records'],
            ['name' => 'Edit Dental Records', 'slug' => 'dental_records.edit', 'module' => 'dental_records'],
            ['name' => 'Delete Dental Records', 'slug' => 'dental_records.delete', 'module' => 'dental_records'],

            // Treatments
            ['name' => 'View Treatments', 'slug' => 'treatments.view', 'module' => 'treatments'],
            ['name' => 'Create Treatments', 'slug' => 'treatments.create', 'module' => 'treatments'],
            ['name' => 'Edit Treatments', 'slug' => 'treatments.edit', 'module' => 'treatments'],
            ['name' => 'Complete Treatments', 'slug' => 'treatments.complete', 'module' => 'treatments'],

            // Invoices & Payments
            ['name' => 'View Invoices', 'slug' => 'invoices.view', 'module' => 'invoices'],
            ['name' => 'Create Invoices', 'slug' => 'invoices.create', 'module' => 'invoices'],
            ['name' => 'Edit Invoices', 'slug' => 'invoices.edit', 'module' => 'invoices'],
            ['name' => 'Delete Invoices', 'slug' => 'invoices.delete', 'module' => 'invoices'],
            ['name' => 'Process Payments', 'slug' => 'payments.create', 'module' => 'payments'],
            ['name' => 'Refund Payments', 'slug' => 'payments.refund', 'module' => 'payments'],

            // Reports
            ['name' => 'View Own Reports', 'slug' => 'reports.view_own', 'module' => 'reports'],
            ['name' => 'View All Reports', 'slug' => 'reports.view_all', 'module' => 'reports'],
            ['name' => 'Export Reports', 'slug' => 'reports.export', 'module' => 'reports'],

            // Settings
            ['name' => 'View Settings', 'slug' => 'settings.view', 'module' => 'settings'],
            ['name' => 'Edit Settings', 'slug' => 'settings.edit', 'module' => 'settings'],
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'module' => 'users'],
            ['name' => 'Manage Subscription', 'slug' => 'subscription.manage', 'module' => 'settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
