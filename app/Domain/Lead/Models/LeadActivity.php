<?php

namespace App\Domain\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domain\Lead\Enums\ActivityType;
use App\Models\User;

class LeadActivity extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    
    protected $fillable = [
        'lead_id',
        'user_id',
        'activity_type',
        'description',
        'metadata',
        'contact_method',
        'duration_minutes',
        'result',
    ];
    
    protected $casts = [
        'activity_type' => ActivityType::class,
        'metadata' => 'array',
        'duration_minutes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // ==================== Relationships ====================
    
    /**
     * Activity belongs to a lead
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
    
    /**
     * Activity belongs to a user (who performed it)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    // ==================== Accessors ====================
    
    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute(): ?string
    {
        if (!$this->duration_minutes) {
            return null;
        }
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }
        
        return "{$minutes}m";
    }
    
    /**
     * Get activity icon
     */
    public function getIconAttribute(): string
    {
        return $this->activity_type->icon();
    }
    
    // ==================== Query Scopes ====================
    
    /**
     * Scope to filter by activity type
     */
    public function scopeOfType($query, ActivityType|string $type)
    {
        $typeValue = $type instanceof ActivityType ? $type->value : $type;
        return $query->where('activity_type', $typeValue);
    }
    
    /**
     * Scope to filter by user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
    
    /**
     * Scope to get recent activities
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
