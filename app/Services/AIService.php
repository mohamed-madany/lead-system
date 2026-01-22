<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected string $apiKey;

    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY'));
    }

    /**
     * Classify a lead based on its data.
     */
    public function classifyLead(array $leadData): ?array
    {
        if (! $this->apiKey) {
            Log::warning('Gemini API key is not set.');

            return null;
        }

        $prompt = $this->buildPrompt($leadData);

        try {
            $response = Http::post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                ],
            ]);

            if ($response->failed()) {
                Log::error('Gemini API Error: '.$response->body());

                return null;
            }

            $result = $response->json();
            $textResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (! $textResponse) {
                return null;
            }

            return json_decode($textResponse, true);

        } catch (\Exception $e) {
            Log::error('AIService Error: '.$e->getMessage());

            return null;
        }
    }

    protected function buildPrompt(array $data): string
    {
        $jsonDetails = json_encode($data, JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
You are a sales expert and lead qualification assistant. 
Analyze the following lead data and provide a classification in JSON format.

Lead Details:
{$jsonDetails}

Expected JSON Output:
{
  "lead_type": "hot" | "warm" | "cold",
  "score": integer (0-100),
  "suggested_action": "A short sentence in Arabic suggesting the best next step",
  "reasoning": "A short sentence in Arabic explaining why it was classified this way"
}

Classification Criteria:
- HOT: Leads with clear intent, company name provided, professional email, or high-value interest.
- WARM: Leads with contact info but less detail, or general inquiries.
- COLD: Minimal info, suspicious data, or very low intent.

Ensure the "suggested_action" and "reasoning" are in Arabic.
PROMPT;
    }
}
