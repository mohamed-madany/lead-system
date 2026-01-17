<?php

namespace Tests\Feature;

use App\Application\Lead\Jobs\SendLeadToN8n;
use App\Domain\Lead\Enums\LeadSource;
use App\Domain\Lead\Models\Lead;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class N8nIntegrationTest extends TestCase
{
    use RefreshDatabase;

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

        config(['services.n8n.webhook_url' => 'https://n8n.test/webhook']);
        config(['services.n8n.webhook_secret' => 'secret']);
    }

    public function test_job_sends_webhook_to_n8n()
    {
        Http::fake([
            'n8n.test/*' => Http::response(['status' => 'success'], 200),
        ]);

        $lead = Lead::factory()->create([
            'tenant_id' => $this->tenant->id,
            'source' => LeadSource::FORM,
        ]);

        $job = new SendLeadToN8n($lead);
        $job->handle();

        Http::assertSent(function ($request) {
            return $request->url() === 'https://n8n.test/webhook' &&
                   $request['lead']['name'] !== null;
        });

        $this->assertDatabaseHas('lead_interactions', [
            'lead_id' => $lead->id,
            'interaction_type' => 'webhook_sent',
        ]);
    }

    public function test_job_retries_on_failure()
    {
        Http::fake([
            'n8n.test/*' => Http::response(['error' => 'Internal Server Error'], 500),
        ]);

        $lead = Lead::factory()->create([
            'tenant_id' => $this->tenant->id,
            'source' => LeadSource::FORM,
        ]);

        $job = new SendLeadToN8n($lead);

        $this->expectException(\Exception::class);
        $job->handle();
    }
}
