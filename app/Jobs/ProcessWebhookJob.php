<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\WebhookLog;

class ProcessWebhookJob
{
    protected $logId;

    public function __construct(int $logId)
    {
        $this->logId = $logId;
    }

    public function handle()
    {
        $log = WebhookLog::find($this->logId);
        if (! $log) return;

         if (($log->attempts ?? 0) >= 5) {
            $log->update(['status' => 'permanent_failed']);
            return;
        }

        $log->update(['status' => 'processing']);

        try {
            $topic = $log->topic;
            $payload = $log->payload;

            switch ($topic) {
                case 'order.created':
                case 'order.updated':
                case 'order.deleted':
                    $this->handleOrder($topic, $payload);
                    break;

                case 'product.created':
                case 'product.updated':
                case 'product.deleted':
                    $this->handleProduct($topic, $payload);
                    break;

                case 'customer.created':
                case 'customer.updated':
                case 'customer.deleted':
                    $this->handleCustomer($topic, $payload);
                    break;

                default:
                    \Log::channel('webhook')->info("Unhandled WooCommerce webhook topic: {$topic}", $payload);
                    break;
            }

            $log->update(['status' => 'processed', 'response' => 'OK']);
        } catch (\Exception $e) {
            \Log::channel('webhook')->error('ProcessWebhookJob failed: ' . $e->getMessage(), ['log_id' => $this->logId]);
            $log->update([
                'status'   => 'failed',
                'response' => $e->getMessage(),
                'retry_at' => now()->addMinutes(5), // retry after 5 minutes
                'attempts' => ($log->attempts ?? 0) + 1,
            ]);
        }
    }

    protected function handleOrder(string $topic, array $payload)
    {
        \Log::channel('webhook')->info("handleOrder: {$topic}", ['id' => $payload['id'] ?? null]);
    }

    protected function handleProduct(string $topic, array $payload)
    {
        \Log::channel('webhook')->info("handleProduct: {$topic}", ['id' => $payload['id'] ?? null]);
    }

    protected function handleCustomer(string $topic, array $payload)
    {
        \Log::channel('webhook')->info("handleCustomer: {$topic}", ['id' => $payload['id'] ?? null]);
    }
}
