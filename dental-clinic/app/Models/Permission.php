<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'module',
        'description',
    ];

    // Relationships
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    // Permission modules
    public const MODULE_PATIENTS = 'patients';

    public const MODULE_APPOINTMENTS = 'appointments';

    public const MODULE_DENTAL_RECORDS = 'dental_records';

    public const MODULE_TREATMENTS = 'treatments';

    public const MODULE_INVOICES = 'invoices';

    public const MODULE_PAYMENTS = 'payments';

    public const MODULE_REPORTS = 'reports';

    public const MODULE_SETTINGS = 'settings';

    public const MODULE_USERS = 'users';
}
