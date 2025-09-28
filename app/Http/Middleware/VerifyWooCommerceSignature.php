<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyWooCommerceSignature
{
    public function handle(Request $request, Closure $next)
    {
        $secret = config('services.woocommerce.webhook_secret');

        if (empty($secret)) {
            Log::channel('webhook')->error('Webhook secret not configured.');
            return response()->json(['message' => 'Webhook secret not configured'], 500);
        }

        $payload = $request->getContent();

        $signature = $request->header('X-WC-Webhook-Signature') 
                  ?? $request->header('x-wc-webhook-signature');

        if (!$signature) {
            Log::channel('webhook')->warning('Missing webhook signature', [
                'headers' => $request->headers->all(),
            ]);
            return response()->json(['message' => 'Missing webhook signature'], 400);
        }

        $computed = base64_encode(hash_hmac('sha256', $payload, $secret, true));

        if (!hash_equals($computed, $signature)) {
            Log::channel('webhook')->error('Invalid webhook signature', [
                'computed' => $computed,
                'received' => $signature,
                'payload'  => $payload,
            ]);
            return response()->json(['message' => 'Invalid webhook signature'], 403);
        }

        Log::channel('webhook')->info('Valid webhook signature', [
            'signature' => $signature,
        ]);

        return $next($request);
    }
}
