<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle Facebook Lead Ads Webhook
     */
    public function facebook(Request $request, $tenantId = null)
    {
        // If tenantId is not in path, try to find it some other way or use default
        $tenant = $tenantId ? \App\Models\Tenant::find($tenantId, ['*']) : null;

        // Challenge verification (GET)
        if ($request->isMethod('get')) {
            if ($request->has('hub_mode') && $request->get('hub_mode') == 'subscribe') {
                $verifyToken = $tenant ? $tenant->facebook_webhook_verify_token : config('lead-system.webhooks.facebook_verify_token');
                
                if ($request->get('hub_verify_token') == $verifyToken) {
                    return response($request->get('hub_challenge'), 200);
                }

                return response('Unauthorized', 403);
            }
        }

        // Handle lead data (POST)
        if ($request->isMethod('post')) {
            Log::info("Facebook Webhook Received for Tenant: {$tenantId}", $request->all());

            // Process leads from FB
            $entries = $request->input('entry', []);
            foreach ($entries as $entry) {
                foreach ($entry['changes'] as $change) {
                    if ($change['field'] === 'leadgen') {
                        $this->processExternalLead($change['value'], 'facebook', $tenant);
                    }
                }
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Method not allowed'], 405);
    }

    /**
     * Handle WhatsApp Webhook
     */
    public function whatsapp(Request $request)
    {
        // Verification (GET)
        if ($request->isMethod('get')) {
            if ($request->has('hub_mode') && $request->get('hub_mode') == 'subscribe') {
                if ($request->get('hub_verify_token') == config('lead-system.webhooks.facebook_verify_token')) {
                    return response($request->get('hub_challenge'), 200);
                }

                return response('Unauthorized', 403);
            }
        }

        // Handle message (POST)
        if ($request->isMethod('post')) {
            Log::info('WhatsApp Webhook Received', $request->all());

            $this->processExternalLead($request->all(), 'whatsapp');

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Method not allowed'], 405);
    }

    /**
     * Process External Lead Data
     */
    private function processExternalLead(array $data, string $source, ?\App\Models\Tenant $tenant = null): void
    {
        // This will be expanded to call FB Graph API or parse WA message
        // For now, we log the intent
        Log::info("Processing lead from {$source} for Tenant: " . ($tenant ? $tenant->id : 'Global'), $data);

        // TODO: Map to LeadService::createLead()
    }
}
