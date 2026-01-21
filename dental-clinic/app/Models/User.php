<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasTenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasTenantScope, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'medical_history',
        'allergies',
        'current_medications',
        'license_number',
        'specialization',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be guarded.
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    // Relationships
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class, 'dentist_id');
    }

    public function dentalRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DentalRecord::class, 'dentist_id');
    }

    // Permission checks
    public function hasPermission(string $permission): bool
    {
        if (! $this->role) {
            return false;
        }

        return $this->role->permissions()
            ->where('slug', $permission)
            ->exists();
    }

    public function isSuperAdmin(): bool
    {
        return $this->tenant_id === null && $this->role?->slug === 'super_admin';
    }

    public function isClinicAdmin(): bool
    {
        return $this->role?->slug === 'clinic_admin';
    }

    public function isDentist(): bool
    {
        return $this->role?->slug === 'dentist';
    }

    public function isReceptionist(): bool
    {
        return $this->role?->slug === 'receptionist';
    }

    public function canAccessTenant(int $tenantId): bool
    {
        return $this->isSuperAdmin() || $this->tenant_id === $tenantId;
    }
}
