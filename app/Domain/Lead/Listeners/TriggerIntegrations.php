<?php

namespace App\Domain\Lead\Listeners;

use App\Domain\Lead\Events\LeadCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TriggerIntegrations implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(LeadCreated $event): void
    {
        $lead = $event->lead;
        $tenant = $lead->tenant;

        if (! $tenant) {
            return;
        }

        // 1. n8n Integration
        if ($tenant->n8n_webhook_url) {
            $this->sendToN8n($tenant->n8n_webhook_url, $lead);
        }

        // 2. Telegram Notifications
        if ($tenant->telegram_bot_token && $tenant->telegram_chat_id) {
            $this->sendToTelegram($tenant->telegram_bot_token, $tenant->telegram_chat_id, $lead);
        }

        // 3. AI Classification (Simulation for now)
        if ($tenant->ai_classification_enabled) {
            $this->processAIClassification($lead);
        }
    }

    protected function sendToN8n(string $url, $lead): void
    {
        try {
            Http::post($url, $lead->toArray());
        } catch (\Exception $e) {
            Log::error('Failed to send lead to n8n: '.$e->getMessage());
        }
    }

    protected function sendToTelegram(string $token, string $chatId, $lead): void
    {
        try {
            $message = "🆕 *عميل جديد وصل!*\n\n";
            $message .= "👤 الاسم: {$lead->name}\n";
            $message .= "📞 الهاتف: {$lead->phone}\n";
            $message .= "✉️ البريد: {$lead->email}\n";
            $message .= "🏢 الشركة: {$lead->company_name}\n";
            $message .= "🔗 المصدر: {$lead->source->value}";

            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send Telegram notification: '.$e->getMessage());
        }
    }

    protected function processAIClassification($lead): void
    {
        // Here you would normally call OpenAI or another AI service
        // For now, we'll just log that it's being processed
        Log::info('AI Classification triggered for lead: '.$lead->id);

        // Example logic:
        // $response = Http::withToken($key)->post('...', ['text' => $lead->notes]);
        // $lead->update(['quality_rating' => ...]);
    }
}
