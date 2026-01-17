<?php

namespace App\Application\Lead\Jobs;

use App\Domain\Lead\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendLeadToN8n implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public int $tries = 3;
    public array $backoff = [60, 300, 900]; // 1min, 5min, 15min
    public int $timeout = 30;
    
    /**
     * Create a new job instance.
     */
    public function __construct(
        public Lead $lead
    ) {}
    
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $webhookUrl = config('services.n8n.webhook_url');
        
        if (!$webhookUrl) {
            Log::warning('N8n webhook URL not configured');
            return;
        }
        
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'X-Webhook-Signature' => $this->generateSignature(),
                    'X-Webhook-ID' => config('services.n8n.webhook_id'),
                    'Content-Type' => 'application/json',
                ])
                ->post($webhookUrl, $this->getPayload());
            
            if ($response->failed()) {
                Log::warning('N8n webhook returned error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'lead_id' => $this->lead->id,
                ]);
                
                throw new \Exception("N8n webhook failed with status: {$response->status()}");
            }
            
            Log::info('N8n webhook sent successfully', [
                'lead_id' => $this->lead->id,
                'status' => $response->status(),
            ]);
            
            // Record the interaction
            $this->lead->recordInteraction(
                'webhook_sent',
                [
                    'webhook' => 'n8n',
                    'status' => $response->status(),
                    'timestamp' => now()->toIso8601String(),
                ]
            );
            
        } catch (\Exception $e) {
            Log::error('N8n webhook exception', [
                'lead_id' => $this->lead->id,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts(),
            ]);
            
            // Re-throw to trigger retry
            throw $e;
        }
    }
    
    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('N8n webhook failed after all retries', [
            'lead_id' => $this->lead->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
        
        // Record the failure
        $this->lead->recordActivity(
            \App\Domain\Lead\Enums\ActivityType::NOTE,
            'N8n webhook failed after all retry attempts',
            [
                'error' => $exception->getMessage(),
                'attempts' => $this->tries,
            ]
        );
    }
    
    /**
     * Get webhook payload
     */
    private function getPayload(): array
    {
        return [
            'event' => 'lead.created',
            'timestamp' => now()->toIso8601String(),
            'lead' => [
                'id' => $this->lead->id,
                'name' => $this->lead->name,
                'email' => $this->lead->email,
                'phone' => $this->lead->phone,
                'company_name' => $this->lead->company_name,
                'job_title' => $this->lead->job_title,
                'status' => $this->lead->status->value,
                'source' => $this->lead->source->value,
                'lead_type' => $this->lead->lead_type->value,
                'score' => $this->lead->score,
                'quality_rating' => $this->lead->quality_rating->value,
                'notes' => $this->lead->notes,
                'estimated_value' => $this->lead->estimated_value,
                'probability_percentage' => $this->lead->probability_percentage,
                'created_at' => $this->lead->created_at->toIso8601String(),
                'assigned_to' => $this->lead->assigned_to,
            ],
            'metadata' => [
                'app_url' => config('app.url'),
                'environment' => config('app.env'),
            ],
        ];
    }
    
    /**
     * Generate HMAC signature for webhook verification
     */
    private function generateSignature(): string
    {
        $payload = json_encode($this->getPayload());
        $secret = config('services.n8n.webhook_secret');
        
        return 'sha256=' . hash_hmac('sha256', $payload, $secret);
    }
}
