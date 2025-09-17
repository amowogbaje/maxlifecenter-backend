<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebhookLog;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payloadRaw = $request->getContent();
        $payload = json_decode($payloadRaw, true) ?? [];

        $topic = $request->header('X-WC-Webhook-Topic') ?? $request->header('x-wc-webhook-topic');
        $resource = $request->header('X-WC-Webhook-Resource') ?? $request->header('x-wc-webhook-resource');
        $deliveryId = $request->header('X-WC-Webhook-ID') ?? $request->header('x-wc-webhook-id');

        $signatureHash = hash('sha256', $payloadRaw);

        $resourceId = $payload['id'] ?? $payload['order_id'] ?? null;

        $existing = WebhookLog::where('signature_hash', $signatureHash)
            ->where('status', 'processed')
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already processed'], 200);
        }

        WebhookLog::create([
            'topic' => $topic,
            'resource' => $resource,
            'resource_id' => $resourceId,
            'delivery_id' => $deliveryId,
            'signature_hash' => $signatureHash,
            'payload' => $payload,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Accepted'], 200);
    }
}
