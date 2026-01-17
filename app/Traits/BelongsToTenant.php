<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check()) {
                $user = auth()->user();
                
                // If user belongs to a tenant, restrict query
                // Platform admins with null tenant_id will see all records
                if ($user->tenant_id) {
                    $builder->where('tenant_id', $user->tenant_id);
                }
            }
        });

        static::creating(function ($model) {
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->tenant_id && !$model->tenant_id) {
                    $model->tenant_id = $user->tenant_id;
                }
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
