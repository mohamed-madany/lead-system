<?php

namespace Tests\Unit;

use App\Application\Lead\Services\LeadScoringService;
use App\Domain\Lead\Models\Lead;
use App\Domain\Lead\Enums\LeadSource;
use App\Models\Tenant;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadScoringServiceTest extends TestCase
{
    use RefreshDatabase;

    protected LeadScoringService $scoringService;
    protected Tenant $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        Plan::create([
            'id' => 1,
            'name' => 'Free Plan',
            'slug' => 'free',
            'price' => 0,
            'max_leads' => 100,
            'max_users' => 1,
        ]);

        $this->tenant = Tenant::create([
            'name' => 'Test Tenant',
            'slug' => 'test-tenant',
            'plan_id' => 1,
        ]);

        $this->scoringService = app(LeadScoringService::class);
    }

    public function test_calculate_score_base_points()
    {
        $lead = Lead::factory()->create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'phone' => '1234567890',
            'source' => LeadSource::FORM,
        ]);

        $score = $this->scoringService->calculateScore($lead);

        // email (20) + phone (25) + source_form (5) = 50
        $this->assertGreaterThanOrEqual(50, $score);
    }

    public function test_corporate_email_bonus()
    {
        $freeLead = Lead::factory()->create([
            'email' => 'user@gmail.com',
            'source' => LeadSource::FORM,
        ]);
        $corpLead = Lead::factory()->create([
            'email' => 'user@microsoft.com',
            'source' => LeadSource::FORM,
        ]);

        $freeScore = $this->scoringService->calculateScore($freeLead);
        $corpScore = $this->scoringService->calculateScore($corpLead);

        $this->assertGreaterThan($freeScore, $corpScore);
    }

    public function test_determine_lead_type()
    {
        $this->assertEquals('cold', $this->scoringService->determineLeadType(20));
        $this->assertEquals('warm', $this->scoringService->determineLeadType(50));
        $this->assertEquals('hot', $this->scoringService->determineLeadType(95));
    }

    public function test_should_auto_qualify()
    {
        $this->assertFalse($this->scoringService->shouldAutoQualify(69));
        $this->assertTrue($this->scoringService->shouldAutoQualify(70));
        $this->assertTrue($this->scoringService->shouldAutoQualify(90));
    }
}
