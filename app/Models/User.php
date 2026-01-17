<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Lead\Models\Lead;
use App\Domain\Lead\Models\LeadActivity;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'role',
        'is_platform_admin',
        'last_login_at',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_platform_admin' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Check if the user can access a specific Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'app') {
            return $this->is_platform_admin === true;
        }

        if ($panel->getId() === 'admin') {
            return true; 
        }

        return false;
    }

    /**
     * Get the tenant the user belongs to.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function getTenants(Panel $panel): array|Collection
    {
        return $this->tenant ? collect([$this->tenant]) : collect();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return (int)$this->tenant_id === (int)$tenant->id;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->is_platform_admin;
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function updateLastLogin(): void
    {
        $this->last_login_at = now();
        $this->save();
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1).substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class, 'user_id');
    }
}
