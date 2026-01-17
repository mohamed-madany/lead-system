<?php

namespace App\Domain\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadInteraction extends Model
{
    use HasFactory;
    
    public $timestamps = false; // Only created_at
    const UPDATED_AT = null;
    
    protected $fillable = [
        'lead_id',
        'interaction_type',
        'interaction_data',
        'ip_address',
        'user_agent',
    ];
    
    protected $casts = [
        'interaction_data' => 'array',
        'created_at' => 'datetime',
    ];
    
    // ==================== Relationships ====================
    
    /**
     * Interaction belongs to a lead
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
    
    // ==================== Accessors ====================
    
    /**
     * Get browser from user agent
     */
    public function getBrowserAttribute(): ?string
    {
        if (!$this->user_agent) {
            return null;
        }
        
        // Simple browser detection
        if (str_contains($this->user_agent, 'Chrome')) {
            return 'Chrome';
        } elseif (str_contains($this->user_agent, 'Firefox')) {
            return 'Firefox';
        } elseif (str_contains($this->user_agent, 'Safari')) {
            return 'Safari';
        } elseif (str_contains($this->user_agent, 'Edge')) {
            return 'Edge';
        }
        
        return 'Unknown';
    }
    
    /**
     * Get device type from user agent
     */
    public function getDeviceAttribute(): string
    {
        if (!$this->user_agent) {
            return 'Unknown';
        }
        
        if (str_contains($this->user_agent, 'Mobile')) {
            return 'Mobile';
        } elseif (str_contains($this->user_agent, 'Tablet')) {
            return 'Tablet';
        }
        
        return 'Desktop';
    }
    
    // ==================== Query Scopes ====================
    
    /**
     * Scope to filter by interaction type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('interaction_type', $type);
    }
    
    /**
     * Scope to get recent interactions
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
