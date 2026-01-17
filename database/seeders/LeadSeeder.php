<?php

namespace Database\Seeders;

use App\Domain\Lead\Models\Lead;
use App\Models\User;
use App\Application\Lead\Services\LeadScoringService;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scoringService = new LeadScoringService();
        $users = User::all();
        
        $leads = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@techcorp.com',
                'phone' => '+1 (555) 123-4567',
                'company_name' => 'TechCorp Inc',
                'job_title' => 'CTO',
                'notes' => 'Interested in enterprise solution for 500+ employees.',
                'source' => 'referral',
                'status' => 'new',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@gmail.com',
                'phone' => '+1 (555) 234-5678',
                'company_name' => 'StartupXYZ',
                'job_title' => 'CEO',
                'notes' => 'Looking for affordable solution for small team.',
                'source' => 'form',
                'status' => 'contacted',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'mchen@innovate.io',
                'phone' => '+1 (555) 345-6789',
                'company_name' => 'Innovate Solutions',
                'job_title' => 'VP of Sales',
                'notes' => 'Needs demo urgently. Budget approved.',
                'source' => 'campaign',
                'status' => 'qualified',
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily.r@megacorp.com',
                'phone' => '+1 (555) 456-7890',
                'company_name' => 'MegaCorp Ltd',
                'job_title' => 'Director of Marketing',
                'notes' => 'Attended webinar, very interested in implementation.',
                'source' => 'campaign',
                'status' => 'new',
            ],
            [
                'name' => 'David Park',
                'email' => 'david@fastgrow.com',
                'phone' => '+1 (555) 567-8901',
                'company_name' => 'FastGrow Inc',
                'job_title' => 'Head of Operations',
                'notes' => 'Comparing with competitors. Price sensitive.',
                'source' => 'form',
                'status' => 'contacted',
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@enterprise.co',
                'phone' => '+1 (555) 678-9012',
                'company_name' => 'Enterprise Co',
                'job_title' => 'CFO',
                'notes' => 'Large enterprise client. High value opportunity.',
                'source' => 'referral',
                'status' => 'qualified',
            ],
            [
                'name' => 'James Wilson',
                'email' => 'jwilson@yahoo.com',
                'phone' => '+1 (555) 789-0123',
                'company_name' => null,
                'job_title' => null,
                'notes' => 'Individual inquiry. No follow-up yet.',
                'source' => 'form',
                'status' => 'new',
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@digitalagency.net',
                'phone' => '+1 (555) 890-1234',
                'company_name' => 'Digital Agency',
                'job_title' => 'Account Manager',
                'notes' => 'Client referred by existing customer.',
                'source' => 'referral',
                'status' => 'won',
                'estimated_value' => 15000.00,
                'probability_percentage' => 100,
            ],
            [
                'name' => 'Robert Taylor',
                'email' => 'rtaylor@oldschool.com',
                'phone' => '+1 (555) 901-2345',
                'company_name' => 'OldSchool Corp',
                'job_title' => 'Manager',
                'notes' => 'Not interested in cloud solutions.',
                'source' => 'campaign',
                'status' => 'lost',
                'metadata' => ['lost_reason' => 'Not ready for cloud migration'],
            ],
            [
                'name' => 'Jennifer Lee',
                'email' => 'jen.lee@moderntech.io',
                'phone' => '+1 (555) 012-3456',
                'company_name' => 'ModernTech',
                'job_title' => 'Product Manager',
                'notes' => 'Scheduled for demo next week.',
                'source' => 'form',
                'status' => 'contacted',
            ],
        ];
        
        foreach ($leads as $leadData) {
            $lead = Lead::create($leadData);
            
            // Calculate and set score
            $score = $scoringService->calculateScore($lead);
            $leadType = $scoringService->determineLeadType($score);
            $qualityRating = $scoringService->determineQualityRating($score);
            
            $lead->update([
                'score' => $score,
                'lead_type' => $leadType,
                'quality_rating' => $qualityRating,
            ]);
            
            // Assign some leads randomly
            if (rand(0, 1) && $users->isNotEmpty()) {
                $lead->assignTo($users->random()->id);
            }
            
            // Set qualified and won dates for appropriate statuses
            if ($lead->status->value === 'qualified') {
                $lead->update(['qualified_at' => now()->subDays(rand(1, 5))]);
            }
            if ($lead->status->value === 'won') {
                $lead->update([
                    'qualified_at' => now()->subDays(rand(10, 20)),
                    'won_at' => now()->subDays(rand(1, 5)),
                ]);
            }
        }
        
        $this->command->info('✅ Created ' . count($leads) . ' sample leads with calculated scores');
    }
}
