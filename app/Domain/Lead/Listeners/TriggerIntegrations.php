<?php

namespace App\Domain\Lead\Listeners;

use App\Domain\Lead\Events\LeadCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Domain\Lead\Enums\QualityRating;

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

        // 1. AI Classification (Do this first if enabled to enrich the data)
        if ($tenant->ai_classification_enabled) {
            $this->processAIClassification($lead);
            // Refresh lead to get updated fields for subsequent integrations
            $lead->refresh();
        }

        // 2. n8n Integration
        if ($tenant->n8n_webhook_url) {
            $this->sendToN8n($tenant->n8n_webhook_url, $lead);
        }

        // 3. Telegram Notifications
        if ($tenant->telegram_bot_token && $tenant->telegram_chat_id) {
            $this->sendToTelegram($tenant->telegram_bot_token, $tenant->telegram_chat_id, $lead);
        }
    }

    protected function sendToN8n(string $url, $lead): void
    {
        try {
            Http::post($url, [
                'event' => 'lead.created',
                'lead' => $lead->toArray(),
                'ai_analysis' => $lead->internal_comments, // Contains the suggested action/reasoning
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send lead to n8n: '.$e->getMessage());
        }
    }

    protected function sendToTelegram(string $token, string $chatId, $lead): void
    {
        try {
            $typeLabel = $lead->lead_type?->getLabel() ?? 'غير مصنف';

            $message = "🆕 *عميل جديد وصل!*\n\n";
            $message .= "👤 الاسم: {$lead->name}\n";
            $message .= "📞 الهاتف: {$lead->phone}\n";
            $message .= "✉️ البريد: {$lead->email}\n";
            $message .= "🏢 الشركة: {$lead->company_name}\n";
            $message .= "🔗 المصدر: {$lead->source->getLabel()}\n\n";

            $message .= "🤖 *تحليل الذكاء الاصطناعي:*\n";
            $message .= "🏷️ التصنيف: *{$typeLabel}*\n";
            $message .= "🎯 النقاط: *{$lead->score}/100*\n";
            $message .= "💡 الإجراء المقترح: {$lead->internal_comments}";

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
        Log::info('AI Classification triggered for lead: '.$lead->id);

        $aiService = app(\App\Services\AIService::class);
        $classification = $aiService->classifyLead($lead->toArray());

        if ($classification) {
            $lead->update([
                'lead_type' => $classification['lead_type'] ?? $lead->lead_type,
                'score' => $classification['score'] ?? $lead->score,
                'internal_comments' => $classification['suggested_action']."\n\nسبب التصنيف: ".$classification['reasoning'],
                'quality_rating' => $this->mapScoreToQuality($classification['score'] ?? 0),
            ]);

            Log::info('AI Classification completed for lead: '.$lead->id);
        }
    }

    protected function mapScoreToQuality(int $score): QualityRating
    {
        if ($score >= 80) {
            return QualityRating::EXCELLENT;
        }
        if ($score >= 60) {
            return QualityRating::GOOD;
        }
        if ($score >= 40) {
            return QualityRating::FAIR;
        }

        return QualityRating::POOR;
    }
}
