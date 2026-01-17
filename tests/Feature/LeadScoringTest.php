<?php

namespace Tests\Feature;

use App\Application\Lead\DTOs\LeadData;
use App\Application\Lead\Services\LeadService;
use App\Domain\Lead\Enums\LeadSource;
use App\Domain\Lead\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadScoringTest extends TestCase
{
    use RefreshDatabase;

    protected Tenant $tenant;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default plan first
        \App\Models\Plan::create([
            'id' => 1,
            'name' => 'Free Plan',
            'slug' => 'free',
            'price' => 0,
            'max_leads' => 100,
            'max_users' => 1,
        ]);

        // Setup a tenant and admin for tests
        $this->tenant = Tenant::create([
            'name' => 'Test Tenant',
            'slug' => 'test-tenant',
            'plan_id' => 1,
        ]);

        $this->admin = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($this->admin);
    }

    public function test_lead_is_created_with_initial_score()
    {
        $leadData = LeadData::fromRequest([
            'tenant_id' => $this->tenant->id,
            'name' => 'John Doe',
            'email' => 'john@company.com',
            'phone' => '1234567890',
            'company_name' => 'Company Inc',
            'job_title' => 'Manager',
            'notes' => 'I am interested in your services.',
            'source' => LeadSource::FORM->value,
        ]);

        $leadService = app(LeadService::class);
        $lead = $leadService->createLead($leadData);

        $this->assertDatabaseHas('leads', [
            'id' => $lead->id,
            'email' => 'john@company.com',
        ]);

        $this->assertNotNull($lead->score);
        $this->assertGreaterThan(0, $lead->score);
        $this->assertNotNull($lead->lead_type);
        $this->assertNotNull($lead->quality_rating);
    }

    public function test_corporate_email_gets_higher_score()
    {
        $leadService = app(LeadService::class);

        // Corporate email
        $corpLead = $leadService->createLead(LeadData::fromRequest([
            'tenant_id' => $this->tenant->id,
            'name' => 'Corp User',
            'email' => 'user@microsoft.com',
            'phone' => '1234567890',
            'source' => LeadSource::FORM->value,
        ]));

        // Free email
        $freeLead = $leadService->createLead(LeadData::fromRequest([
            'tenant_id' => $this->tenant->id,
            'name' => 'Free User',
            'email' => 'user@gmail.com',
            'phone' => '1234567890',
            'source' => LeadSource::FORM->value,
        ]));

        $this->assertGreaterThan($freeLead->score, $corpLead->score);
    }

    public function test_auto_qualification_threshold()
    {
        $leadService = app(LeadService::class);

        // Very high quality lead (should be auto-qualified)
        $hotLead = $leadService->createLead(LeadData::fromRequest([
            'tenant_id' => $this->tenant->id,
            'name' => 'Hot Prospect',
            'email' => 'ceo@bigcorp.com',
            'phone' => '1234567890',
            'company_name' => 'Big Corp',
            'job_title' => 'CEO',
            'notes' => 'This is a very long note to increase the score. We need this solution immediately for our global team of 500 people.',
            'source' => LeadSource::REFERRAL->value,
        ]));

        $this->assertEquals('qualified', $hotLead->status->value);
        $this->assertEquals('hot', $hotLead->lead_type->value);
    }
}
