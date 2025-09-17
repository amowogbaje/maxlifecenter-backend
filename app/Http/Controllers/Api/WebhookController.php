<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\WebhookLog;
use App\Jobs\ProcessWebhookJob;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    /**
     * Handle incoming WooCommerce webhook
     */
    public function handle(Request $request)
    {
        // Raw JSON payload (string)
        $payloadRaw = $request->getContent();
        $payload = json_decode($payloadRaw, true) ?? [];

        // Headers WooCommerce provides
        $topic = $request->header('X-WC-Webhook-Topic') ?? $request->header('x-wc-webhook-topic');
        $resource = $request->header('X-WC-Webhook-Resource') ?? $request->header('x-wc-webhook-resource');
        $deliveryId = $request->header('X-WC-Webhook-ID') ?? $request->header('x-wc-webhook-id'); // may be present in some setups

        $signatureHash = hash('sha256', $payloadRaw);

        // Optional: try to derive resource id from payload (common patterns)
        $resourceId = null;
        if (isset($payload['id'])) $resourceId = (string) $payload['id'];
        elseif (isset($payload['order_id'])) $resourceId = (string) $payload['order_id'];
        // Add more heuristics as needed

        // Idempotency: if we've processed the exact payload already, respond 200 quickly
        $existing = WebhookLog::where('signature_hash', $signatureHash)
            ->where('status', 'processed')
            ->first();

        if ($existing) {
            // already handled
            return response()->json(['message' => 'Already processed'], 200);
        }

        // Create log
        $log = WebhookLog::create([
            'topic' => $topic,
            'resource' => $resource,
            'resource_id' => $resourceId,
            'delivery_id' => $deliveryId,
            'signature_hash' => $signatureHash,
            'payload' => $payload,
            'status' => 'pending',
        ]);

        // Dispatch job to process webhook (queued)
        ProcessWebhookJob::dispatch($log->id);

        // Respond 200 quickly so WooCommerce doesn't mark as failed (200–204 accepted)
        return response()->json(['message' => 'Accepted'], 200);
    }
}
