<?php

namespace Tests\Feature;

use App\Domain\Lead\Enums\LeadSource;
use App\Livewire\LeadCaptureForm;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LeadCreationTest extends TestCase
{
    use RefreshDatabase;

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

        // Setup a tenant
        $this->tenant = Tenant::create([
            'name' => 'Test Tenant',
            'slug' => 'test-tenant',
            'plan_id' => 1,
        ]);
    }

    public function test_can_submit_lead_form()
    {
        Livewire::test(LeadCaptureForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '0123456789')
            ->set('source', LeadSource::FORM->value)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('showSuccess', true)
            ->assertViewHas('leadTrackingId', function ($id) {
                return ! empty($id);
            });

        $this->assertDatabaseHas('leads', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '0123456789',
        ]);
    }

    public function test_validation_works()
    {
        Livewire::test(LeadCaptureForm::class)
            ->set('name', '')
            ->set('email', 'not-an-email')
            ->set('phone', 'short')
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'phone', 'source']);
    }

    public function test_honeypot_prevents_submission()
    {
        Livewire::test(LeadCaptureForm::class)
            ->set('name', 'Bot User')
            ->set('email', 'bot@example.com')
            ->set('phone', '0123456789')
            ->set('source', LeadSource::FORM->value)
            ->set('website', 'http://malicious.com') // Honeypot field
            ->call('submit')
            ->assertSet('showSuccess', true); // Should look successful to the bot

        $this->assertDatabaseMissing('leads', [
            'email' => 'bot@example.com',
        ]);
    }

    public function test_real_time_validation()
    {
        Livewire::test(LeadCaptureForm::class)
            ->set('email', 'invalid-email')
            ->assertHasErrors(['email' => 'email']);
    }
}
