<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::where('slug', 'cudalblanco')->first();

        if (! $tenant) {
            return;
        }

        // Create sample patients
        $patients = [
            [
                'tenant_id' => $tenant->id,
                'patient_code' => 'P-001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '09171234567',
                'date_of_birth' => '1990-01-15',
                'gender' => 'male',
                'address' => '123 Main Street',
                'city' => 'Manila',
                'postal_code' => '1000',
                'blood_type' => 'O+',
                'is_active' => true,
            ],
            [
                'tenant_id' => $tenant->id,
                'patient_code' => 'P-002',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '09181234567',
                'date_of_birth' => '1985-05-20',
                'gender' => 'female',
                'address' => '456 Oak Avenue',
                'city' => 'Quezon City',
                'postal_code' => '1100',
                'blood_type' => 'A+',
                'allergies' => ['Penicillin'],
                'medical_conditions' => ['Hypertension'],
                'is_active' => true,
            ],
            [
                'tenant_id' => $tenant->id,
                'patient_code' => 'P-003',
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'email' => 'maria.garcia@example.com',
                'phone' => '09191234567',
                'date_of_birth' => '1995-08-10',
                'gender' => 'female',
                'address' => '789 Pine Street',
                'city' => 'Makati',
                'postal_code' => '1200',
                'blood_type' => 'B+',
                'is_active' => true,
            ],
        ];

        foreach ($patients as $patientData) {
            Patient::create($patientData);
        }

        $this->command->info('Demo data seeded successfully!');
    }
}
