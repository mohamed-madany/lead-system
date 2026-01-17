<?php

namespace App\Domain\Lead\Models;

use App\Domain\Lead\Enums\LeadSource;
use App\Domain\Lead\Enums\LeadStatus;
use App\Domain\Lead\Enums\LeadType;
use App\Domain\Lead\Enums\QualityRating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'job_title',
        'status',
        'source',
        'lead_type',
        'score',
        'score_breakdown',
        'quality_rating',
        'notes',
        'internal_comments',
        'metadata',
        'assigned_to',
        'assigned_at',
        'last_contacted_at',
        'qualified_at',
        'won_at',
        'estimated_value',
        'probability_percentage',
    ];

    protected $casts = [
        'status' => LeadStatus::class,
        'source' => LeadSource::class,
        'lead_type' => LeadType::class,
        'quality_rating' => QualityRating::class,
        'score' => 'integer',
        'probability_percentage' => 'integer',
        'estimated_value' => 'decimal:2',
        'assigned_at' => 'datetime',
        'last_contacted_at' => 'datetime',
        'qualified_at' => 'datetime',
        'won_at' => 'datetime',
        'metadata' => 'array',
        'score_breakdown' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => \App\Domain\Lead\Events\LeadCreated::class,
        'updated' => \App\Domain\Lead\Events\LeadUpdated::class,
    ];

    // ==================== Business Methods ====================

    /**
     * Qualify the lead
     */
    public function qualify(): void
    {
        $this->update([
            'status' => LeadStatus::QUALIFIED,
            'qualified_at' => now(),
        ]);

        event(new \App\Domain\Lead\Events\LeadQualified($this));
    }

    /**
     * Mark lead as won
     */
    public function markAsWon(?float $value = null): void
    {
        $this->update([
            'status' => LeadStatus::WON,
            'won_at' => now(),
            'estimated_value' => $value ?? $this->estimated_value,
            'probability_percentage' => 100,
        ]);

        event(new \App\Domain\Lead\Events\LeadWon($this));
    }

    /**
     * Mark lead as lost
     */
    public function markAsLost(?string $reason = null): void
    {
        $metadata = $this->metadata ?? [];
        if ($reason) {
            $metadata['lost_reason'] = $reason;
            $metadata['lost_at'] = now()->toDateTimeString();
        }

        $this->update([
            'status' => LeadStatus::LOST,
            'metadata' => $metadata,
            'probability_percentage' => 0,
        ]);

        event(new \App\Domain\Lead\Events\LeadLost($this));
    }

    /**
     * Mark lead as contacted
     */
    public function markAsContacted(): void
    {
        $this->update([
            'status' => LeadStatus::CONTACTED,
            'last_contacted_at' => now(),
        ]);
    }

    /**
     * Archive the lead
     */
    public function archive(): void
    {
        $this->update([
            'status' => LeadStatus::ARCHIVED,
        ]);
    }

    /**
     * Assign lead to a user
     */
    public function assignTo(int $userId): void
    {
        $previousAssignedTo = $this->assigned_to;

        $this->update([
            'assigned_to' => $userId,
            'assigned_at' => now(),
        ]);

        // Log activity
        $this->recordActivity(
            \App\Domain\Lead\Enums\ActivityType::ASSIGNMENT,
            "Lead assigned to user ID: {$userId}",
            [
                'previous_assigned_to' => $previousAssignedTo,
                'new_assigned_to' => $userId,
            ]
        );
    }

    /**
     * Update lead score
     */
    public function updateScore(int $newScore, ?array $breakdown = null): void
    {
        $oldScore = $this->score;

        $this->update([
            'score' => $newScore,
            'score_breakdown' => $breakdown ?? $this->score_breakdown,
        ]);

        // Log activity
        $this->recordActivity(
            \App\Domain\Lead\Enums\ActivityType::SCORE_UPDATE,
            "Score updated from {$oldScore} to {$newScore}",
            [
                'old_score' => $oldScore,
                'new_score' => $newScore,
                'breakdown' => $breakdown,
            ]
        );

        event(new \App\Domain\Lead\Events\LeadScored($this));
    }

    /**
     * Record an activity for this lead
     */
    public function recordActivity(
        \App\Domain\Lead\Enums\ActivityType|string $type,
        string $description,
        array $metadata = []
    ): LeadActivity {
        return $this->activities()->create([
            'activity_type' => $type instanceof \App\Domain\Lead\Enums\ActivityType ? $type->value : $type,
            'description' => $description,
            'metadata' => $metadata,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Record an interaction
     */
    public function recordInteraction(
        string $type,
        ?array $data = null,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): LeadInteraction {
        return $this->interactions()->create([
            'interaction_type' => $type,
            'interaction_data' => $data,
            'ip_address' => $ipAddress ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent(),
        ]);
    }

    /**
     * Check if lead can be edited
     */
    public function canBeEdited(): bool
    {
        return ! $this->status->isTerminal();
    }

    /**
     * Get full name with company
     */
    public function getFullNameAttribute(): string
    {
        return $this->company_name
            ? "{$this->name} ({$this->company_name})"
            : $this->name;
    }

    // ==================== Relationships ====================

    /**
     * Lead belongs to a user (assigned to)
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Lead has many activities
     */
    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class)->orderByDesc('created_at');
    }

    /**
     * Lead has many interactions
     */
    public function interactions(): HasMany
    {
        return $this->hasMany(LeadInteraction::class)->orderByDesc('created_at');
    }

    // ==================== Query Scopes ====================

    /**
     * Scope to get qualified leads
     */
    public function scopeQualified($query)
    {
        return $query->where('status', LeadStatus::QUALIFIED);
    }

    /**
     * Scope to get new leads
     */
    public function scopeNew($query)
    {
        return $query->where('status', LeadStatus::NEW);
    }

    /**
     * Scope to filter by source
     */
    public function scopeBySource($query, LeadSource|string $source)
    {
        $sourceValue = $source instanceof LeadSource ? $source->value : $source;

        return $query->where('source', $sourceValue);
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, LeadStatus|string $status)
    {
        $statusValue = $status instanceof LeadStatus ? $status->value : $status;

        return $query->where('status', $statusValue);
    }

    /**
     * Scope to get high-scoring leads
     */
    public function scopeWithHighScore($query, int $minScore = 70)
    {
        return $query->where('score', '>=', $minScore);
    }

    /**
     * Scope to get hot leads
     */
    public function scopeHot($query)
    {
        return $query->where('lead_type', LeadType::HOT);
    }

    /**
     * Scope to filter by assigned user
     */
    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope to get unassigned leads
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    /**
     * Scope to filter by date range
     */
    public function scopeCreatedBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope to get recent leads
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope to search leads
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('company_name', 'like', "%{$search}%");
        });
    }
}
