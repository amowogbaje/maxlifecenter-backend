<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WooCommerceService
{

    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;


    public function __construct()
    {
        $this->baseUrl = 'https://watchlocker.ng/wp-json/wc/v3/';
        $this->consumerKey = env('WOOCOMMERCE_CONSUMER_KEY');
        $this->consumerSecret = env('WOOCOMMERCE_CONSUMER_SECRET');
    }
    /**
     * Sync multiple orders from WooCommerce payload
     *
     * @param array $orders
     */
    public function syncOrders(array $orders): void
    {
        foreach ($orders as $orderData) {
            try {
                DB::transaction(function () use ($orderData, &$order) {
                    $order = $this->syncOrder($orderData);
                });

                if ($order) {
                    Log::info("✅ Order synced successfully", [
                        'woo_order_id' => $orderData['id'] ?? null
                    ]);
                } else {
                    Log::warning("⏩ Order skipped (guest checkout)", [
                        'woo_order_id' => $orderData['id'] ?? null
                    ]);
                }
            } catch (Throwable $e) {
                Log::error("❌ Failed to sync WooCommerce order", [
                    'woo_order_id' => $orderData['id'] ?? null,
                    'message'      => $e->getMessage(),
                    'trace'        => $e->getTraceAsString(),
                ]);
            }
        }
    }

    /**
     * Sync a single WooCommerce order
     *
     * @param array $orderData
     * @return Order
     */
    /**
 * Sync a single WooCommerce order
 *
 * @param array $orderData
 * @return Order|null
 */
    protected function syncOrder(array $orderData): ?Order
    {
        if (empty($orderData['customer_id']) || $orderData['customer_id'] == 0) {
            Log::warning("Skipping guest order", [
                'woo_order_id' => $orderData['id'] ?? null,
            ]);
            return null;
        }

        $user = User::updateOrCreate(
            [
                // 'woo_id' => $orderData['customer_id'],
                'email'  => $orderData['billing']['email'],
            ],
            [
                'woo_id'     => $orderData['customer_id'],
                'first_name' => $orderData['billing']['first_name'] ?? null,
                'last_name'  => $orderData['billing']['last_name'] ?? null,
                'email'      => $orderData['billing']['email'] ?? null,
                'phone'      => $orderData['billing']['phone'] ?? null,
                'address_1'  => $orderData['billing']['address_1'] ?? null,
                'address_2'  => $orderData['billing']['address_2'] ?? null,
                'city'       => $orderData['billing']['city'] ?? null,
                'state'      => $orderData['billing']['state'] ?? null,
                'postcode'   => $orderData['billing']['postcode'] ?? null,
                'country'    => $orderData['billing']['country'] ?? null,
            ]
        );

        $order = Order::updateOrCreate(
            ['woo_id' => $orderData['id']],
            [
                'woo_id'               => $orderData['id'],
                'user_id'              => $user->id,
                'status'               => $orderData['status'] ?? 'pending',
                'currency'             => $orderData['currency'] ?? null,
                'total'                => $orderData['total'] ?? 0,
                'bonus_point'          => $orderData['total'] ? $orderData['total']/1000 : 0,
                'discount_total'       => $orderData['discount_total'] ?? 0,
                'shipping_total'       => $orderData['shipping_total'] ?? 0,
                'payment_method'       => $orderData['payment_method'] ?? null,
                'payment_method_title' => $orderData['payment_method_title'] ?? null,
                'transaction_id'       => $orderData['transaction_id'] ?? null,
                'date_created'         => $orderData['date_created'] ?? null,
                'date_modified'        => $orderData['date_modified'] ?? null,
                'date_completed'       => $orderData['date_completed'] ?? null,
                'date_paid'            => $orderData['date_paid'] ?? null,
                'meta_data'            => $orderData['meta_data'] ?? [],
            ]
        );

        if (!empty($orderData['line_items'])) {
            foreach ($orderData['line_items'] as $item) {
                $product = Product::updateOrCreate(
                    ['woo_id' => $item['product_id']],
                    [
                        'woo_id'    => $item['product_id'],
                        'name'      => $item['name'],
                        'image_url' => $item['image']['src'] ?? null,
                        'price'     => $item['price'] ?? 0,
                        'sku'       => $item['sku'] ?? null,
                    ]
                );

                OrderItem::updateOrCreate(
                    ['woo_id' => $item['id']],
                    [
                        'woo_id'     => $item['id'],
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $item['quantity'],
                        'subtotal'   => $item['subtotal'] ?? 0,
                        'total'      => $item['total'] ?? 0,
                    ]
                );
            }
        }

        return $order;
    }



    public function fetchOrders($afterDate)
    {
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get($this->baseUrl . 'orders', [
                'per_page' => 100,
                'after'    => $afterDate,
                'status'   => 'completed',
                'order'    => 'asc'
            ]);

        if ($response->failed()) {
            Log::error('WooCommerce API Error: ' . $response->body());
            return [];
        }

        return $response->json();
    }


}
