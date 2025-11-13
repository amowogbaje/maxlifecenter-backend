<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Analytics;
use DB;

class UpdateAnalytics extends Command
{
    // Command signature
    protected $signature = 'analytics:update';

    // Command description
    protected $description = 'Update analytics data for the dashboard';

    public function handle()
    {
        $this->info('Updating analytics...');

        $currentMonth = now()->month;
        $previousMonth = $currentMonth === 1 ? 12 : $currentMonth - 1;
        $currentYear = now()->year;
        $previousYear = $currentMonth === 1 ? $currentYear - 1 : $currentYear;

        // Helper to calculate percentage change
        $calculateChange = function ($currentMonthTotal, $previousMonthTotal) {
            if ($previousMonthTotal == 0) return "+100%";
            $change = (($currentMonthTotal - $previousMonthTotal) / $previousMonthTotal) * 100;
            return ($change >= 0 ? "+" : "") . round($change, 1) . "%";
        };

        // --- Compute overall totals ---
        $totalSales = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::where('status', 'completed')->count();
        $totalProductsSold = OrderItem::distinct('product_id')->count('product_id');

        // --- Compute previous and current month totals for change ---
        $salesCurrentMonth = Order::where('status', 'completed')
            ->whereYear('date_completed', $currentYear)
            ->whereMonth('date_completed', $currentMonth)
            ->sum('total');

        $salesPreviousMonth = Order::where('status', 'completed')
            ->whereYear('date_completed', $previousYear)
            ->whereMonth('date_completed', $previousMonth)
            ->sum('total');

        $ordersCurrentMonth = Order::where('status', 'completed')
            ->whereYear('date_completed', $currentYear)
            ->whereMonth('date_completed', $currentMonth)
            ->count();

        $ordersPreviousMonth = Order::where('status', 'completed')
            ->whereYear('date_completed', $previousYear)
            ->whereMonth('date_completed', $previousMonth)
            ->count();

        $productsCurrentMonth = OrderItem::whereHas('order', function ($q) use ($currentYear, $currentMonth) {
            $q->where('status', 'completed')
                ->whereYear('date_completed', $currentYear)
                ->whereMonth('date_completed', $currentMonth);
        })->distinct('product_id')->count('product_id');

        $productsPreviousMonth = OrderItem::whereHas('order', function ($q) use ($previousYear, $previousMonth) {
            $q->where('status', 'completed')
                ->whereYear('date_completed', $previousYear)
                ->whereMonth('date_completed', $previousMonth);
        })->distinct('product_id')->count('product_id');

        // --- Prepare stats cards with dynamic monthly change ---
        $statsCards = [
            [
                'title' => "Total Sales",
                'value' => '₦' . number_format($totalSales),
                'change' => $calculateChange($salesCurrentMonth, $salesPreviousMonth),
                'icon' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                'bgColor' => "bg-red-500",
                'changeColor' => ($salesCurrentMonth >= $salesPreviousMonth) ? 'text-green-500 bg-green-50' : 'text-red-500 bg-red-50',
            ],
            [
                'title' => "Total Orders",
                'value' => $totalOrders,
                'change' => $calculateChange($ordersCurrentMonth, $ordersPreviousMonth),
                'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m5.5-5.5h.01M17 13h.01',
                'bgColor' => "bg-blue-500",
                'changeColor' => ($ordersCurrentMonth >= $ordersPreviousMonth) ? 'text-green-500 bg-green-50' : 'text-red-500 bg-red-50',
            ],
            [
                'title' => "Total Sold Products",
                'value' => $totalProductsSold,
                'change' => $calculateChange($productsCurrentMonth, $productsPreviousMonth),
                'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m5.5-5.5h.01M17 13h.01',
                'bgColor' => "bg-green-500",
                'changeColor' => ($productsCurrentMonth >= $productsPreviousMonth) ? 'text-green-500 bg-green-50' : 'text-red-500 bg-red-50',
            ],
        ];

        $salesData = [];
        $maxValue = 0;

        for ($month = 1; $month <= 12; $month++) {
            $monthlyTotal = Order::where('status', 'completed')
                ->whereYear('date_completed', $currentYear)
                ->whereMonth('date_completed', $month)
                ->sum('total');

            $salesData[] = [
                'month' => date('M', mktime(0, 0, 0, $month, 10)),
                'value' => (float) $monthlyTotal, // force numeric
            ];

            if ($monthlyTotal > $maxValue) $maxValue = $monthlyTotal;
        }

        // yAxisLabels (8 steps)
        $yAxisLabels = [];
        $step = ceil($maxValue / 8);

        for ($i = 8; $i >= 1; $i--) {
            $value = $step * $i;
            $yAxisLabels[] = $this->formatNumber($value);
        }


        // Category, Pie, Top Products (dummy or computed)
        $categoryData = [
            ['month' => "Home Goods", 'percentage' => 20],
            ['month' => "Books", 'percentage' => 19],
            ['month' => "Hook", 'percentage' => 21],
            ['month' => "Egg", 'percentage' => 18],
            ['month' => "Books", 'percentage' => 10],
            ['month' => "Sports", 'percentage' => 12],
        ];
        $pieChartData = [
            ['label' => "Home Goods", 'color' => "#222683", 'percentage' => 20],
            ['label' => "Books", 'color' => "#4A86E4", 'percentage' => 22],
            ['label' => "Books", 'color' => "#4A86E4", 'percentage' => 22],
            ['label' => "Books", 'color' => "#4A86E4", 'percentage' => 22],
            ['label' => "Books", 'color' => "#4A86E4", 'percentage' => 22],
        ];

        // Get all products with sales totals
        $topProductsQuery = OrderItem::select(
            'product_id',
            DB::raw('SUM(quantity) as total_sold'),
            DB::raw('SUM(subtotal * quantity) as total_revenue')
        )
            ->whereHas('order', function ($q) use ($currentYear) {
                $q->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold') // top-selling products
            ->limit(3) // top 10 products
            ->get();

        // Prepare topProducts array
        $topProducts = $topProductsQuery->map(function ($item) use ($previousYear, $previousMonth) {

            // Sales last month
            $previousMonthSales = OrderItem::where('product_id', $item->product_id)
                ->whereHas('order', function ($q) use ($previousYear, $previousMonth) {
                    $q->where('status', 'completed')
                        ->whereYear('date_completed', $previousYear)
                        ->whereMonth('date_completed', $previousMonth);
                })
                ->sum('quantity');

            // Percentage change
            if ($previousMonthSales == 0) {
                $change = "+100%";
                $changeColor = "text-green-500 bg-green-50";
            } else {
                $percentChange = (($item->total_sold - $previousMonthSales) / $previousMonthSales) * 100;
                $change = ($percentChange >= 0 ? "+" : "") . round($percentChange, 1) . "%";
                $changeColor = $percentChange >= 0 ? "text-green-500 bg-green-50" : "text-red-500 bg-red-50";
            }

            return [
                'name' => $item->product->name ?? "Product {$item->product_id}",
                'price' => "₦" . number_format($item->total_revenue, 0),
                'sales' => $item->total_sold . " sales",
                'change' => $change,
                'image' => $item->product->image_url ?? '',
                'changeColor' => $changeColor,
            ];
        })->toArray();

        $year = date('Y');

        // Update or create analytics row
        Analytics::updateOrCreate(
            ['id' => 1], // single row for dashboard
            [
                'stats_cards' => $statsCards,
                'sales_data' => $salesData,
                'category_data' => $categoryData,
                'pie_chart_data' => $pieChartData,
                'top_products' => $topProducts,
                'y_axis_labels' => $yAxisLabels,
                'year' => $year,
            ]
        );

        $this->info('Analytics updated successfully!');
    }

    function formatNumber($number)
    {
        if ($number >= 1_000_000_000) {
            return round($number / 1_000_000_000, 1) . 'B';
        } elseif ($number >= 1_000_000) {
            return round($number / 1_000_000, 1) . 'M';
        } elseif ($number >= 1_000) {
            return round($number / 1_000, 1) . 'K';
        } else {
            return (string)$number;
        }
    }
}
