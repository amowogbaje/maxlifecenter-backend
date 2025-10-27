<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\WooCommerceService;
use App\Models\ProductOnSale;

class SyncWooProducts extends Command
{
    protected $signature = 'sync:woo-products';
    protected $description = 'Sync WooCommerce products with the local database';

    public function __construct(protected WooCommerceService $wooService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('🔄 Fetching products from WooCommerce...');

        try {
            $products = $this->wooService->fetchProductsOnSales();

            if (isset($products['error']) && $products['error']) {
                $this->error('❌ ' . $products['message']);
                return Command::FAILURE;
            }

            $count = 0;

            foreach ($products as $wooProduct) {
                $product = ProductOnSale::updateOrCreate(
                    ['woo_id' => $wooProduct['id']], // condition
                    [
                        'name' => $wooProduct['name'],
                        'price' => $wooProduct['price'],
                        'image_url' => $wooProduct['images'][0]['src'] ?? null,
                        'on_sale' => $wooProduct['on_sale'] ?? false,
                    ]
                );

                $count++;
            }

            $this->info("✅ Synced {$count} products successfully!");
            return Command::SUCCESS;

        } catch (\Throwable $e) {
            Log::error('Woo Sync Error: ' . $e->getMessage());
            $this->error('⚠️ Failed to sync products. Check logs for details.');
            return Command::FAILURE;
        }
    }
}
