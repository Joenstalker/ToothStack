<?php

namespace App\Models;

use App\Traits\HasTenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DentalRecord extends Model
{
    use HasFactory, HasTenantScope, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'patient_id', 'appointment_id', 'dentist_id', 'date',
        'chief_complaint', 'diagnosis', 'treatment_plan', 'procedures_done',
        'prescriptions', 'tooth_chart', 'attachments', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'treatment_plan' => 'array',
            'procedures_done' => 'array',
            'prescriptions' => 'array',
            'tooth_chart' => 'array',
            'attachments' => 'array',
        ];
    }

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentist(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
