<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WooCommerceService;
use App\Models\SyncCursor;
use App\Models\SyncLog;
use Illuminate\Support\Facades\Log;

class SyncWooOrders extends Command
{
    protected $signature = 'woo:sync-orders';
    protected $description = 'Incremental sync of WooCommerce orders';

    public function handle()
    {
        try {
            $woocommerceService = new WooCommerceService();

            Log::info('Starting WooCommerce orders sync');

            $cursor = SyncCursor::firstOrCreate([], ['last_date' => '2025-01-01T00:00:00Z']);
            $orders = $woocommerceService->fetchOrders($cursor->last_date);

            if (empty($orders)) {
                Log::info('No new orders found.');
                $this->info('No new orders to sync.');

                SyncLog::create([
                    'last_date' => $cursor->last_date,
                    'order_ids' => [],
                    'status'    => 'no-orders',
                ]);

                return Command::SUCCESS;
            }

            $woocommerceService->syncOrders($orders);

            $lastOrder = end($orders);
            $newDate   = $lastOrder['date_created'];

            // ✅ Only update if the new date is actually later
            if ($newDate > $cursor->last_date) {
                $cursor->update(['last_date' => $newDate]);

                SyncLog::create([
                    'last_date' => $newDate,
                    'order_ids' => array_column($orders, 'id'),
                    'status'    => 'success',
                ]);

                Log::info('Orders synced successfully', [
                    'last_date' => $newDate,
                ]);

                $this->info('Batch sync completed successfully.');
            } else {
                Log::warning('Cursor date did not advance, stopping to avoid reprocessing.', [
                    'last_date' => $cursor->last_date,
                ]);

                SyncLog::create([
                    'last_date' => $cursor->last_date,
                    'order_ids' => array_column($orders, 'id'),
                    'status'    => 'stalled',
                ]);

                $this->warn('Sync skipped because cursor did not advance.');
            }

            return Command::SUCCESS;

        } catch (\Throwable $e) {
            Log::error('WooCommerce sync failed', [
                'last_date' => $cursor->last_date,
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            SyncLog::create([
                'last_date' => now(),
                'order_ids' => [],
                'status'    => 'failed',
            ]);

            $this->error("Sync failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
