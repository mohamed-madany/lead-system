<?php

namespace App\Application\Lead\Services;

use App\Domain\Lead\Models\Lead;

class LeadScoringService
{
    /**
     * Calculate lead score based on configured rules
     */
    public function calculateScore(Lead $lead): int
    {
        $breakdown = [];
        $totalScore = 0;
        $config = config('lead-system.scoring.points');
        
        // Contact Information Points
        $totalScore += $breakdown['email'] = $lead->email ? $config['email_provided'] : 0;
        $totalScore += $breakdown['phone'] = $lead->phone ? $config['phone_provided'] : 0;
        $totalScore += $breakdown['company'] = $lead->company_name ? $config['company_name'] : 0;
        $totalScore += $breakdown['job_title'] = $lead->job_title ? $config['job_title'] : 0;
        
        // Email Quality Points
        if ($lead->email) {
            $isCorporate = $this->isCorporateEmail($lead->email);
            $totalScore += $breakdown['corporate_email'] = $isCorporate ? $config['corporate_email'] : 0;
            
            $isQuality = $this->isQualityEmail($lead->email);
            if (!$isQuality) {
                $totalScore += $breakdown['spam_keywords'] = $config['spam_keywords_penalty'];
            }
        }
        
        // Content Quality Points
        if ($lead->notes && strlen($lead->notes) > 50) {
            $totalScore += $breakdown['full_message'] = $config['full_message'];
        }
        
        // Source Quality Points
        $totalScore += $breakdown['source'] = $this->getSourceScore($lead->source->value);
        
        // Timing Bonus
        $totalScore += $breakdown['timing'] = $this->getTimingScore($lead->created_at);
        
        // Clamp score to 0-100 range
        $totalScore = min(100, max(0, $totalScore));
        
        return $totalScore;
    }
    
    /**
     * Check if email is from a corporate domain
     */
    private function isCorporateEmail(string $email): bool
    {
        $domain = explode('@', $email)[1] ?? '';
        $freeProviders = config('lead-system.scoring.free_email_providers', []);
        
        return !in_array($domain, $freeProviders);
    }
    
    /**
     * Check email quality (no spam patterns)
     */
    private function isQualityEmail(string $email): bool
    {
        $spamKeywords = config('lead-system.scoring.spam_keywords', []);
        $pattern = '/' . implode('|', $spamKeywords) . '/i';
        
        return !preg_match($pattern, $email);
    }
    
    /**
     * Get score points based on lead source
     */
    private function getSourceScore(string $source): int
    {
        $config = config('lead-system.scoring.points');
        
        return match($source) {
            'referral' => $config['source_referral'],
            'campaign' => $config['source_campaign'],
            'form' => $config['source_form'],
            default => 0,
        };
    }
    
    /**
     * Get timing bonus based on when lead was created
     */
    private function getTimingScore($createdAt): int
    {
        $hour = $createdAt->hour;
        $config = config('lead-system.scoring.points');
        
        // Business hours bonus (9am-5pm)
        return ($hour >= 9 && $hour < 17) ? $config['business_hours_bonus'] : 0;
    }
    
    /**
     * Determine if lead should be auto-qualified based on score
     */
    public function shouldAutoQualify(int $score): bool
    {
        $threshold = config('lead-system.scoring.qualification_threshold', 70);
        return $score >= $threshold;
    }
    
    /**
     * Determine lead type based on score
     */
    public function determineLeadType(int $score): string
    {
        $hotThreshold = config('lead-system.scoring.hot_lead_threshold', 90);
        $coldThreshold = config('lead-system.scoring.cold_lead_threshold', 30);
        
        if ($score >= $hotThreshold) {
            return 'hot';
        } elseif ($score >= 60) {
            return 'warm';
        } elseif ($score < $coldThreshold) {
            return 'cold';
        }
        
        return 'warm';
    }
    
    /**
     * Determine quality rating based on score
     */
    public function determineQualityRating(int $score): string
    {
        return match(true) {
            $score >= 90 => 'excellent',
            $score >= 70 => 'good',
            $score >= 40 => 'fair',
            default => 'poor',
        };
    }
}
