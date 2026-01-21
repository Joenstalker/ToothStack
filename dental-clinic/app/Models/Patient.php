<?php

namespace App\Models;

use App\Traits\HasTenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, HasTenantScope, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'patient_code', 'first_name', 'last_name', 'email', 'phone',
        'date_of_birth', 'gender', 'address', 'city', 'postal_code',
        'emergency_contact_name', 'emergency_contact_phone', 'blood_type',
        'allergies', 'medical_conditions', 'current_medications',
        'insurance_provider', 'insurance_number', 'photo', 'notes', 'is_active',
    ];

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'allergies' => 'array',
            'medical_conditions' => 'array',
            'current_medications' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function dentalRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DentalRecord::class);
    }

    public function treatments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Treatment::class);
    }

    public function invoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
