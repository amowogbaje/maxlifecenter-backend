<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyWooCommerceSignature
{
    public function handle(Request $request, Closure $next)
    {
        $secret = config('services.woocommerce.webhook_secret');

        if (empty($secret)) {
            return response()->json(['message' => 'Webhook secret not configured'], 500);
        }

        $payload = $request->getContent();

        $signature = $request->header('X-WC-Webhook-Signature') ?? $request->header('x-wc-webhook-signature');

        if (!$signature) {
            return response()->json(['message' => 'Missing webhook signature'], 400);
        }

        $computed = base64_encode(hash_hmac('sha256', $payload, $secret, true));

        if (!hash_equals($computed, $signature)) {
            return response()->json(['message' => 'Invalid webhook signature'], 403);
        }

        return $next($request);
    }
}
