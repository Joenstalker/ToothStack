<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'subscription_plan',
        'subscription_status',
        'subscription_ends_at',
        'trial_ends_at',
        'max_users',
        'max_patients',
        'features',
        'settings',
        'branding',
        'database_connection',
        'is_active',
        'contact_email',
        'contact_phone',
        'address',
        'city',
        'postal_code',
        'country',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'settings' => 'array',
            'branding' => 'array',
            'is_active' => 'boolean',
            'subscription_ends_at' => 'datetime',
            'trial_ends_at' => 'datetime',
        ];
    }

    // Relationships
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TenantSubscription::class);
    }

    public function patients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->is_active && $this->subscription_status === 'active';
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? []);
    }

    public function canAddUsers(): bool
    {
        return $this->users()->count() < $this->max_users;
    }

    public function canAddPatients(): bool
    {
        return $this->patients()->count() < $this->max_patients;
    }

    public function isOnTrial(): bool
    {
        return $this->subscription_status === 'trial' &&
               $this->trial_ends_at &&
               $this->trial_ends_at->isFuture();
    }
}
