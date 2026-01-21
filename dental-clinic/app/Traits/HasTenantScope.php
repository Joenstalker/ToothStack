<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasTenantScope
{
    /**
     * Boot the trait and add global scope
     */
    protected static function bootHasTenantScope(): void
    {
        // Automatically add tenant_id on create
        static::creating(function (Model $model) {
            if (! $model->tenant_id && Auth::check()) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });

        // Global scope - NEVER query without tenant_id (unless super admin)
        static::addGlobalScope('tenant', function (Builder $query) {
            if (Auth::check() && ! static::isSuperAdmin()) {
                $query->where($query->getModel()->getTable().'.tenant_id', Auth::user()->tenant_id);
            }
        });
    }

    /**
     * Check if current user is super admin
     */
    protected static function isSuperAdmin(): bool
    {
        return Auth::check() && Auth::user()->tenant_id === null;
    }

    /**
     * Get tenant relationship
     */
    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }

    /**
     * Scope to get all records without tenant filter (super admin only)
     */
    public function scopeWithoutTenantScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }

    /**
     * Scope to filter by specific tenant
     */
    public function scopeForTenant(Builder $query, int $tenantId): Builder
    {
        return $query->withoutGlobalScope('tenant')->where('tenant_id', $tenantId);
    }
}
