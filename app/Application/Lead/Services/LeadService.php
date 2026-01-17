<?php

namespace App\Application\Lead\Services;

use App\Application\Lead\DTOs\LeadData;
use App\Application\Lead\Jobs\SendLeadToN8n;
use App\Domain\Lead\Enums\ActivityType;
use App\Domain\Lead\Models\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeadService
{
    public function __construct(
        private LeadScoringService $scoringService,
    ) {}

    /**
     * Create a new lead
     */
    public function createLead(LeadData $data): Lead
    {
        return DB::transaction(function () use ($data) {
            // Create the lead
            $lead = Lead::create($data->toArray());

            // Calculate and set initial score
            $score = $this->scoringService->calculateScore($lead);
            $leadType = $this->scoringService->determineLeadType($score);
            $qualityRating = $this->scoringService->determineQualityRating($score);

            $lead->update([
                'score' => $score,
                'lead_type' => $leadType,
                'quality_rating' => $qualityRating,
            ]);

            // Auto-qualify if score is high enough
            if ($this->scoringService->shouldAutoQualify($score)) {
                $lead->qualify();
            }

            // Log creation activity
            $lead->recordActivity(
                ActivityType::NOTE,
                "Lead created from {$lead->source->label()} with initial score of {$score}",
                ['initial_score' => $score, 'auto_qualified' => $score >= 70]
            );

            // Dispatch webhook job
            if (config('lead-system.webhooks.n8n.enabled', false)) {
                SendLeadToN8n::dispatch($lead);
            }

            Log::info('Lead created', ['lead_id' => $lead->id, 'score' => $score]);

            return $lead->fresh();
        });
    }

    /**
     * Update an existing lead
     */
    public function updateLead(Lead $lead, LeadData $data): Lead
    {
        return DB::transaction(function () use ($lead, $data) {
            $oldScore = $lead->score;

            // Update lead data
            $lead->update($data->toArray());

            // Recalculate score
            $newScore = $this->scoringService->calculateScore($lead);

            if ($newScore !== $oldScore) {
                $leadType = $this->scoringService->determineLeadType($newScore);
                $qualityRating = $this->scoringService->determineQualityRating($newScore);

                $lead->update([
                    'score' => $newScore,
                    'lead_type' => $leadType,
                    'quality_rating' => $qualityRating,
                ]);

                $lead->recordActivity(
                    ActivityType::SCORE_UPDATE,
                    "Score updated from {$oldScore} to {$newScore}",
                    ['old_score' => $oldScore, 'new_score' => $newScore]
                );
            }

            return $lead->fresh();
        });
    }

    /**
     * Delete a lead (soft delete)
     */
    public function deleteLead(Lead $lead): bool
    {
        Log::info('Lead deleted', ['lead_id' => $lead->id]);

        return $lead->delete();
    }

    /**
     * Change lead status
     */
    public function changeStatus(Lead $lead, string $newStatus): Lead
    {
        $oldStatus = $lead->status->value;

        $lead->update(['status' => $newStatus]);

        $lead->recordActivity(
            ActivityType::STATUS_CHANGE,
            "Status changed from {$oldStatus} to {$newStatus}",
            ['old_status' => $oldStatus, 'new_status' => $newStatus]
        );

        return $lead->fresh();
    }

    /**
     * Assign lead to a user
     */
    public function assignToUser(Lead $lead, int $userId): Lead
    {
        $lead->assignTo($userId);

        return $lead->fresh();
    }

    /**
     * Qualify a lead
     */
    public function qualifyLead(Lead $lead): Lead
    {
        $lead->qualify();

        Log::info('Lead qualified', ['lead_id' => $lead->id, 'score' => $lead->score]);

        return $lead->fresh();
    }

    /**
     * Mark lead as won
     */
    public function markAsWon(Lead $lead, ?float $value = null): Lead
    {
        $lead->markAsWon($value);

        Log::info('Lead won', ['lead_id' => $lead->id, 'value' => $value ?? $lead->estimated_value]);

        return $lead->fresh();
    }

    /**
     * Mark lead as lost
     */
    public function markAsLost(Lead $lead, ?string $reason = null): Lead
    {
        $lead->markAsLost($reason);

        Log::info('Lead lost', ['lead_id' => $lead->id, 'reason' => $reason]);

        return $lead->fresh();
    }

    /**
     * Bulk update leads
     */
    public function bulkUpdate(array $leadIds, array $updates): int
    {
        return DB::transaction(function () use ($leadIds, $updates) {
            $count = Lead::whereIn('id', $leadIds)->update($updates);

            Log::info('Bulk update performed', [
                'count' => $count,
                'updates' => array_keys($updates),
            ]);

            return $count;
        });
    }

    /**
     * Get lead statistics
     */
    public function getStatistics(?string $period = 'all'): array
    {
        $query = Lead::query();

        // Apply date filter
        if ($period !== 'all') {
            $date = $this->getDateForPeriod($period);
            if ($date) {
                $query->where('created_at', '>=', $date);
            }
        }

        return [
            'total' => $query->count(),
            'new' => (clone $query)->new()->count(),
            'contacted' => (clone $query)->byStatus('contacted')->count(),
            'qualified' => (clone $query)->qualified()->count(),
            'won' => (clone $query)->byStatus('won')->count(),
            'lost' => (clone $query)->byStatus('lost')->count(),
            'archived' => (clone $query)->byStatus('archived')->count(),
            'average_score' => (clone $query)->avg('score') ?? 0,
            'high_score_count' => (clone $query)->withHighScore()->count(),
            'unassigned' => (clone $query)->unassigned()->count(),
        ];
    }

    /**
     * Get conversion metrics
     */
    public function getConversionMetrics(): array
    {
        $total = Lead::count();
        $won = Lead::byStatus('won')->count();
        $lost = Lead::byStatus('lost')->count();

        return [
            'total_leads' => $total,
            'won_leads' => $won,
            'lost_leads' => $lost,
            'conversion_rate' => $total > 0 ? round(($won / $total) * 100, 2) : 0,
            'loss_rate' => $total > 0 ? round(($lost / $total) * 100, 2) : 0,
            'win_loss_ratio' => $lost > 0 ? round($won / $lost, 2) : 0,
        ];
    }

    /**
     * Get source distribution
     */
    public function getSourceDistribution(): array
    {
        return Lead::query()
            ->selectRaw('source, COUNT(*) as count')
            ->groupBy('source')
            ->pluck('count', 'source')
            ->toArray();
    }

    /**
     * Helper to get date for period
     */
    private function getDateForPeriod(string $period): ?\Carbon\Carbon
    {
        return match ($period) {
            'today' => now()->startOfDay(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'quarter' => now()->startOfQuarter(),
            'year' => now()->startOfYear(),
            default => null,
        };
    }
}
