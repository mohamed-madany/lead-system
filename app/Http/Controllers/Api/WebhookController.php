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
    public function facebook(Request $request)
    {
        // Challenge verification (GET)
        if ($request->isMethod('get')) {
            if ($request->has('hub_mode') && $request->get('hub_mode') == 'subscribe') {
                if ($request->get('hub_verify_token') == config('lead-system.webhooks.facebook_verify_token')) {
                    return response($request->get('hub_challenge'), 200);
                }

                return response('Unauthorized', 403);
            }
        }

        // Handle lead data (POST)
        if ($request->isMethod('post')) {
            Log::info('Facebook Webhook Received', $request->all());

            // TODO: Implement parsing of Facebook Lead payload
            // $entry = $request->input('entry.0');
            // $changes = $entry['changes'][0];
            // ... process lead

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

            // TODO: Implement parsing of WhatsApp payload

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Method not allowed'], 405);
    }
}
