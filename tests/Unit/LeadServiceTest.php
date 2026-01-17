<?php

namespace Tests\Unit;

use App\Application\Lead\DTOs\LeadData;
use App\Application\Lead\Services\LeadService;
use App\Application\Lead\Services\LeadScoringService;
use App\Domain\Lead\Enums\LeadSource;
use App\Domain\Lead\Enums\LeadStatus;
use App\Domain\Lead\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadServiceTest extends TestCase
{
    use RefreshDatabase;

    protected LeadService $leadService;
    protected Tenant $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default plan
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

        $this->leadService = app(LeadService::class);
    }

    public function test_can_create_lead()
    {
        $data = LeadData::fromRequest([
            'tenant_id' => $this->tenant->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '0123456789',
            'source' => LeadSource::FORM->value,
        ]);

        $lead = $this->leadService->createLead($data);

        $this->assertInstanceOf(Lead::class, $lead);
        $this->assertEquals('Jane Doe', $lead->name);
        $this->assertDatabaseHas('leads', ['email' => 'jane@example.com']);
    }

    public function test_can_update_lead_status()
    {
        $lead = Lead::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '1234567890',
            'status' => LeadStatus::NEW->value,
            'source' => LeadSource::FORM->value,
        ]);

        $updatedLead = $this->leadService->changeStatus($lead, LeadStatus::CONTACTED->value);

        $this->assertEquals(LeadStatus::CONTACTED->value, $updatedLead->status->value);
        $this->assertDatabaseHas('leads', [
            'id' => $lead->id,
            'status' => LeadStatus::CONTACTED->value,
        ]);
    }

    public function test_can_assign_lead_to_user()
    {
        $user = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Sales Rep',
            'email' => 'sales@test.com',
            'password' => bcrypt('password'),
        ]);

        $lead = Lead::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '1234567890',
            'source' => LeadSource::FORM->value,
        ]);

        $this->leadService->assignToUser($lead, $user->id);

        $this->assertEquals($user->id, $lead->fresh()->assigned_to);
    }

    public function test_can_get_statistics()
    {
        Lead::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Lead 1',
            'email' => 'l1@test.com',
            'phone' => '123',
            'status' => 'new',
            'source' => 'form',
        ]);

        Lead::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Lead 2',
            'email' => 'l2@test.com',
            'phone' => '456',
            'status' => 'won',
            'source' => 'referral',
        ]);

        $stats = $this->leadService->getStatistics();

        $this->assertEquals(2, $stats['total']);
        $this->assertEquals(1, $stats['new']);
        $this->assertEquals(1, $stats['won']);
    }
}
