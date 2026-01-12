<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Analytics;
use App\Models\User;
use App\Models\AuditLog;
use App\Models\Reward;
use App\Models\UserReward;
use Carbon\Carbon; 

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $rewardIcon = '<svg class="w-4 h-4 text-white" viewBox="0 0 12 12" fill="currentColor"><path d="M2.25 1C1.56 1 1 1.56 1 2.25V3.412C1.00027 3.67934 1.07198 3.94175 1.20771 4.17207C1.34344 4.40239 1.53826 4.59225 1.772 4.722L4.648 6.321C4.0456 6.62512 3.56332 7.12345 3.27909 7.73549C2.99486 8.34752 2.92528 9.03751 3.08159 9.69398C3.2379 10.3504 3.61097 10.935 4.14052 11.3533C4.67008 11.7716 5.32518 11.9991 6 11.9991C6.67482 11.9991 7.32992 11.7716 7.85948 11.3533C8.38903 10.935 8.7621 10.3504 8.91841 9.69398C9.07472 9.03751 9.00514 8.34752 8.72091 7.73549C8.43668 7.12345 7.9544 6.62512 7.352 6.321L10.229 4.723C10.4627 4.59304 10.6574 4.40297 10.793 4.17246C10.9285 3.94196 11 3.67941 11 3.412V2.25C11 1.56 10.44 1 9.75 1H2.25ZM5 5.372V2H7V5.372L6 5.928L5 5.372ZM8 9C8 9.53043 7.78929 10.0391 7.41421 10.4142C7.03914 10.7893 6.53043 11 6 11C5.46957 11 4.96086 10.7893 4.58579 10.4142C4.21071 10.0391 4 9.53043 4 9C4 8.46957 4.21071 7.96086 4.58579 7.58579C4.96086 7.21071 5.46957 7 6 7C6.53043 7 7.03914 7.21071 7.41421 7.58579C7.78929 7.96086 8 8.46957 8 9Z"/></svg>';
        $usersIcon = '<svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12C14.21 12 16 10.21 16 8S14.21 4 12 4 8 5.79 8 8 9.79 12 12 12M12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"/></svg>';
        $purchases = Order::where('status', 'completed');
        $purchaseCount = $purchases->count();
        $purchaseTotal = $purchases->sum('total');
        $totalUsersCount = User::count();
        $eleniyan = Reward::withCount('activeUsers')->where('title', 'Eleniyan')->first();
        $oloye    = Reward::withCount('activeUsers')->where('title', 'Oloye')->first();
        $balogun  = Reward::withCount('activeUsers')->where('title', 'Balogun')->first();
        $kabiyesi = Reward::withCount('activeUsers')->where('title', 'Kabiyesi')->first();
        // $tiers = Reward::withCount('users')->orderBy('priority')->get();
        // return $kabiyesi;

        

        $metricCards = [
            ['title' => $purchaseCount, 'subtitle' => 'Earnings', 'value' => '₦' . number_format($purchaseTotal), 'bgColor' => 'bg-purple', 'icon' => $rewardIcon, 'hasAvatar' => false],
            ['title' => $totalUsersCount, 'subtitle' => 'Users',  'bgColor' => 'bg-success', 'icon' => $usersIcon, 'hasAvatar' => false],
            ['title' => $eleniyan->active_users_count, 'subtitle' => 'Total Count - ELENIYAN', 'bgColor' => 'bg-green-500/20', 'icon' => $rewardIcon, 'hasAvatar' => true, 'avatarIcon' => 'images/eleniyan.png'],
            ['title' => $oloye->active_users_count, 'subtitle' => 'Total Count - OLOYE', 'bgColor' => 'bg-green-500/20', 'icon' => $rewardIcon, 'hasAvatar' => true, 'avatarIcon' => 'images/balogun.png'],
            ['title' => $balogun->active_users_count, 'subtitle' => 'Total Count - BALOGUN', 'bgColor' => 'bg-green-500/20', 'icon' => $rewardIcon, 'hasAvatar' => true, 'avatarIcon' => 'images/kabiyesi.png'],
            ['title' => $kabiyesi->active_users_count, 'subtitle' => 'Total Count - KABIYESI', 'bgColor' => 'bg-green-500/20', 'icon' => $rewardIcon, 'hasAvatar' => true, 'avatarIcon' => 'images/oloye.png'],
        ];

        $search = $request->input('search');
        $query = AuditLog::with('admin')->latest();

        if ($search) {
            $normalizedDate = null;

            try {
                $timestamp = strtotime($search);
                if ($timestamp !== false) {
                    $normalizedDate = date('Y-m-d', $timestamp);
                }
            } catch (\Exception $e) {
                $normalizedDate = null;
            }

            $query->where(function ($q) use ($search, $normalizedDate) {
                $q->where('action', 'like', "%{$search}%")
                ->orWhereHas('admin', function ($userQuery) use ($search) {
                    $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                });

                if (!empty($normalizedDate)) { // ✅ safer null/empty check
                    $q->orWhereDate('created_at', $normalizedDate);
                }
            });
        }


        $activityLogs = $query->paginate(10)->appends($request->query());
        return view('admin.dashboard', compact('metricCards', 'activityLogs'));
    }

    public function analytics()
    {
        // 1. Current Date
        $currentDate = \Carbon\Carbon::now()->isoFormat('dddd, MMMM D, YYYY');

        // 2. Fetch analytics data from DB
        // Assume the 'analytics' table has a single row with all precomputed data
        $analytics = Analytics::first();

        $statsCards = $analytics->stats_cards ?? '[]';
        $salesData = $analytics->sales_data ?? '[]';
        $categoryData = $analytics->category_data ?? '[]';
        $pieChartData = $analytics->pie_chart_data ?? '[]';
        $topProducts = $analytics->top_products ?? '[]';

        // 3. Chart Axes/Helpers (keep simple)
        $yAxisLabels = $analytics->y_axis_labels ?? '["800k","700k","600k","500k","400k","300k","200k","100k"]';
        $selectedYear = $analytics->year ?? date('Y');

        // return compact(
        //     'currentDate',
        //     'statsCards',
        //     'salesData',
        //     'categoryData',
        //     'pieChartData',
        //     'topProducts',
        //     'yAxisLabels',
        //     'selectedYear'
        // );
        // $salesData = [
        //     ['month' => "Jan", 'value' => 47],
        //     ['month' => "Feb", 'value' => 73],
        //     ['month' => "Mar", 'value' => 76],
        //     ['month' => "Apr", 'value' => 55],
        //     ['month' => "May", 'value' => 73],
        //     ['month' => "Jun", 'value' => 101],
        //     ['month' => "Jul", 'value' => 77],
        //     ['month' => "Aug", 'value' => 48],
        //     ['month' => "Sep", 'value' => 70],
        //     ['month' => "Oct", 'value' => 115],
        //     ['month' => "Nov", 'value' => 125],
        //     ['month' => "Dec", 'value' => 48],
        // ];

        // 4. Pass all data to the view
        return view('admin.analytics', compact(
            'currentDate',
            'statsCards',
            'salesData',
            'categoryData',
            'pieChartData',
            'topProducts',
            'yAxisLabels',
            'selectedYear'
        ));
    }

    public function analytics2()
    {
        // 1. Current Date
        $currentDate = Carbon::now()->isoFormat('dddd, MMMM D, YYYY');
        

        // 2. Stats Cards Data
        $statsCards = [
            [
                'title' => "Total Sales",
                'value' => "₦120,000",
                'change' => "+5.4%",
                'icon' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                'bgColor' => "bg-red-500",
                'changeColor' => "text-gray-500 bg-gray-50",
            ],
            [
                'title' => "Total Order",
                'value' => "146",
                'change' => "+5.4%",
                'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m5.5-5.5h.01M17 13h.01',
                'bgColor' => "bg-blue-500",
                'changeColor' => "text-gray-500 bg-gray-50",
            ],
            [
                'title' => "Total Sold Product",
                'value' => "106",
                'change' => "+5.4%",
                'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m5.5-5.5h.01M17 13h.01',
                'bgColor' => "bg-blue-500",
                'changeColor' => "text-gray-500 bg-gray-50",
            ],
        ];

        // 3. Sales Chart Data
        $salesData = [
            ['month' => "Jan", 'value' => 47],
            ['month' => "Feb", 'value' => 73],
            ['month' => "Mar", 'value' => 76],
            ['month' => "Apr", 'value' => 55],
            ['month' => "May", 'value' => 73],
            ['month' => "Jun", 'value' => 101],
            ['month' => "Jul", 'value' => 77],
            ['month' => "Aug", 'value' => 48],
            ['month' => "Sep", 'value' => 70],
            ['month' => "Oct", 'value' => 115],
            ['month' => "Nov", 'value' => 125],
            ['month' => "Dec", 'value' => 48],
        ];

        // 4. Category Bar Chart Data
        $categoryData = [
            ['month' => "Electronics", 'percentage' => 74],
            ['month' => "Apparel", 'percentage' => 27],
            ['month' => "Home Goods", 'percentage' => 54],
            ['month' => "Books", 'percentage' => 59],
            ['month' => "Sports", 'percentage' => 82],
            ['month' => "Beauty", 'percentage' => 67],
        ];
        
        // 5. Pie Chart Data
        $pieChartData = [
            ['label' => "Electronics", 'color' => "#FFBE00", 'percentage' => 16],
            ['label' => "Apparel", 'color' => "#D377F3", 'percentage' => 5],
            ['label' => "Home Goods", 'color' => "#222683", 'percentage' => 20],
            ['label' => "Books", 'color' => "#4A86E4", 'percentage' => 22],
            ['label' => "Sports", 'color' => "#EF746D", 'percentage' => 19],
            ['label' => "Beauty", 'color' => "#5D923D", 'percentage' => 18],
        ];

        // 6. Top Selling Products Data
        $topProducts = [
            [
                'name' => "Product A",
                'price' => "₦100,000",
                "image" => "https://watchlocker.ng/wp-content/uploads/2020/03/MTP-1314L-7AVDF.jpg",
                'sales' => "247+ sales",
                'change' => "+5.4%",
                'changeColor' => "text-gray-500 bg-gray-50",
            ],
            [
                'name' => "Product B",
                "image" => "https://watchlocker.ng/wp-content/uploads/2020/03/MTP-1314L-7AVDF.jpg",
                'price' => "₦100,000",
                'sales' => "247+ sales",
                'change' => "-5.4%",
                'changeColor' => "text-red-500 bg-red-50",
            ],
            // Add more dummy data if needed...
        ];
        
        // 7. Chart Axes/Helpers (can be kept simple)
        $yAxisLabels = ['800k', '700k', '600k', '500k', '400k', '300k', '200k', '100k'];
        $selectedYear = date('Y'); // Current year

        // Pass all data to the view
        return view('admin.analytics', compact(
            'currentDate',
            'statsCards',
            'salesData',
            'categoryData',
            'pieChartData',
            'topProducts',
            'yAxisLabels',
            'selectedYear'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user =  $admin = Admin::find($request->admin_id);;
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'phone'      => 'nullable|string|max:20',
            'location'   => 'nullable|string|max:255',
            'birthday'   => 'nullable|date|before:today|after:1900-01-01',
            'bio'        => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $admin->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
        ]);
    }

    

    public function purchases(Request $request)
    {
        $rewardIcon = '<svg class="w-4 h-4 text-white" viewBox="0 0 12 12" fill="currentColor"><path d="M2.25 1C1.56 1 1 1.56 1 2.25V3.412C1.00027 3.67934 1.07198 3.94175 1.20771 4.17207C1.34344 4.40239 1.53826 4.59225 1.772 4.722L4.648 6.321C4.0456 6.62512 3.56332 7.12345 3.27909 7.73549C2.99486 8.34752 2.92528 9.03751 3.08159 9.69398C3.2379 10.3504 3.61097 10.935 4.14052 11.3533C4.67008 11.7716 5.32518 11.9991 6 11.9991C6.67482 11.9991 7.32992 11.7716 7.85948 11.3533C8.38903 10.935 8.7621 10.3504 8.91841 9.69398C9.07472 9.03751 9.00514 8.34752 8.72091 7.73549C8.43668 7.12345 7.9544 6.62512 7.352 6.321L10.229 4.723C10.4627 4.59304 10.6574 4.40297 10.793 4.17246C10.9285 3.94196 11 3.67941 11 3.412V2.25C11 1.56 10.44 1 9.75 1H2.25ZM5 5.372V2H7V5.372L6 5.928L5 5.372ZM8 9C8 9.53043 7.78929 10.0391 7.41421 10.4142C7.03914 10.7893 6.53043 11 6 11C5.46957 11 4.96086 10.7893 4.58579 10.4142C4.21071 10.0391 4 9.53043 4 9C4 8.46957 4.21071 7.96086 4.58579 7.58579C4.96086 7.21071 5.46957 7 6 7C6.53043 7 7.03914 7.21071 7.41421 7.58579C7.78929 7.96086 8 8.46957 8 9Z"/></svg>';
        $usersIcon = '<svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12C14.21 12 16 10.21 16 8S14.21 4 12 4 8 5.79 8 8 9.79 12 12 12M12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"/></svg>';

        $purchases = Order::where('status', 'completed');
        $purchaseCount = $purchases->count();
        $purchaseTotal = $purchases->sum('total');
        $bonusPointTotal = $purchases->where('reward_status', 'pending')->sum('bonus_point');
        $totalUsersCount = User::count();

        $metricCards = [
            ['title' => number_format($bonusPointTotal), 'subtitle' => 'Bonus Point Pending Approval', 'bgColor' => 'bg-purple', 'icon' => $rewardIcon, 'hasAvatar' => false],
            ['title' => $purchaseCount, 'subtitle' => 'Total No. of Purchases', 'bgColor' => 'bg-success', 'icon' => $usersIcon, 'hasAvatar' => false],
            ['title' => '₦' . number_format($purchaseTotal), 'subtitle' => 'Total Amount Spent', 'bgColor' => 'bg-warning', 'icon' => $rewardIcon, 'hasAvatar' => false],
            ['title' => $totalUsersCount, 'subtitle' => 'Purchasing Users', 'bgColor' => 'bg-warning', 'icon' => $rewardIcon, 'hasAvatar' => false],
        ];

        $search = $request->input('search');
        $query = Order::with('user')->latest();

        if ($search) {
            $normalizedDate = null;
            try {
                $timestamp = strtotime($search);
                if ($timestamp !== false) {
                    $normalizedDate = date('Y-m-d', $timestamp);
                }
            } catch (\Exception $e) {
                $normalizedDate = null;
            }

            $query->where(function ($q) use ($search, $normalizedDate) { // ✅ include $normalizedDate here
                $q->where('woo_id', 'like', "%{$search}%")
                ->orWhere('total', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereDate('created_at', $search);

                if ($normalizedDate) {
                    $q->orWhereDate('date_completed', $normalizedDate);
                }
            });
        }


        $purchases = $query->orderBy('date_created', 'desc')->paginate(1000)->appends($request->query());

        return view('admin.purchase', compact('metricCards', 'purchases'));
    }

    public function showPurchase($id) {
        $purchase = Order::with(['items.product'])->find($id);
        $user = User::find($purchase->user_id);
        
        return view('admin.purchase-details', compact('purchase', 'user'));
    }

    public function rewards(Request $request)
    {
        $totalApprovedRewards = UserReward::where('status', 'claimed')->count();
        $pendingRewards = UserReward::where('status', 'pending')->count();
        $pendingCartSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 20" class="w-6 h-6 fill-current text-white">
            <!-- Original cart paths -->
            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.68539 5.34736L5.34041 12.5194C5.38821 13.0714 5.87812 13.4854 6.47665 13.4854H6.481H18.3333H18.3355C18.9015 13.4854 19.3849 13.0974 19.4652 12.5824L20.4972 6.02336C20.5211 5.86736 20.4787 5.71136 20.3755 5.58536C20.2734 5.45836 20.1235 5.37636 19.9541 5.35436C19.727 5.36236 10.3058 5.35036 4.68539 5.34736ZM6.47448 14.9854C5.04386 14.9854 3.83266 13.9574 3.71643 12.6424L2.7214 1.74836L1.08439 1.48836C0.640099 1.41636 0.343546 1.02936 0.419585 0.620365C0.497797 0.211365 0.926875 -0.054635 1.36139 0.00936497L3.62084 0.369365C3.98474 0.428365 4.26174 0.706365 4.29324 1.04636L4.54851 3.84736C20.0562 3.85336 20.1061 3.86036 20.1811 3.86836C20.7861 3.94936 21.3184 4.24036 21.6812 4.68836C22.0441 5.13536 22.1961 5.68636 22.1092 6.23836L21.0784 12.7964C20.8839 14.0444 19.7064 14.9854 18.3377 14.9854H18.3323H6.48317H6.47448Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5908 9.0437H13.5797C13.1289 9.0437 12.765 8.7077 12.765 8.2937C12.765 7.8797 13.1289 7.5437 13.5797 7.5437H16.5908C17.0406 7.5437 17.4056 7.8797 17.4056 8.2937C17.4056 8.7077 17.0406 9.0437 16.5908 9.0437Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00717 17.7019C6.33413 17.7019 6.5981 17.9449 6.5981 18.2459C6.5981 18.5469 6.33413 18.7909 6.00717 18.7909C5.67911 18.7909 5.41515 18.5469 5.41515 18.2459C5.41515 17.9449 5.67911 17.7019 6.00717 17.7019Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00608 18.0408C5.88333 18.0408 5.78339 18.1328 5.78339 18.2458C5.78339 18.4728 6.22985 18.4728 6.22985 18.2458C6.22985 18.1328 6.12883 18.0408 6.00608 18.0408ZM6.00608 19.5408C5.23048 19.5408 4.60044 18.9598 4.60044 18.2458C4.60044 17.5318 5.23048 16.9518 6.00608 16.9518C6.78168 16.9518 7.4128 17.5318 7.4128 18.2458C7.4128 18.9598 6.78168 19.5408 6.00608 19.5408Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2607 17.7019C18.5876 17.7019 18.8527 17.9449 18.8527 18.2459C18.8527 18.5469 18.5876 18.7909 18.2607 18.7909C17.9326 18.7909 17.6686 18.5469 17.6686 18.2459C17.6686 17.9449 17.9326 17.7019 18.2607 17.7019Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2596 18.0408C18.1379 18.0408 18.038 18.1328 18.038 18.2458C18.0391 18.4748 18.4844 18.4728 18.4834 18.2458C18.4834 18.1328 18.3823 18.0408 18.2596 18.0408ZM18.2596 19.5408C17.484 19.5408 16.8539 18.9598 16.8539 18.2458C16.8539 17.5318 17.484 16.9518 18.2596 16.9518C19.0363 16.9518 19.6674 17.5318 19.6674 18.2458C19.6674 18.9598 19.0363 19.5408 18.2596 19.5408Z"/>
            
            <!-- Clock overlay -->
            <circle cx="19" cy="3" r="3" fill="#F59E0B" class="text-yellow-500"/>
            <circle cx="19" cy="3" r="1.2" stroke="white" stroke-width="0.8" fill="none"/>
            <path d="M19 3L19 1.8" stroke="white" stroke-width="0.8"/>
            <path d="M19 3L20.2 3" stroke="white" stroke-width="0.8"/>
        </svg>';

        $approvedCartSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 20" class="w-6 h-6 fill-current text-white">
            <!-- Original cart paths -->
            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.68539 5.34736L5.34041 12.5194C5.38821 13.0714 5.87812 13.4854 6.47665 13.4854H6.481H18.3333H18.3355C18.9015 13.4854 19.3849 13.0974 19.4652 12.5824L20.4972 6.02336C20.5211 5.86736 20.4787 5.71136 20.3755 5.58536C20.2734 5.45836 20.1235 5.37636 19.9541 5.35436C19.727 5.36236 10.3058 5.35036 4.68539 5.34736ZM6.47448 14.9854C5.04386 14.9854 3.83266 13.9574 3.71643 12.6424L2.7214 1.74836L1.08439 1.48836C0.640099 1.41636 0.343546 1.02936 0.419585 0.620365C0.497797 0.211365 0.926875 -0.054635 1.36139 0.00936497L3.62084 0.369365C3.98474 0.428365 4.26174 0.706365 4.29324 1.04636L4.54851 3.84736C20.0562 3.85336 20.1061 3.86036 20.1811 3.86836C20.7861 3.94936 21.3184 4.24036 21.6812 4.68836C22.0441 5.13536 22.1961 5.68636 22.1092 6.23836L21.0784 12.7964C20.8839 14.0444 19.7064 14.9854 18.3377 14.9854H18.3323H6.48317H6.47448Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5908 9.0437H13.5797C13.1289 9.0437 12.765 8.7077 12.765 8.2937C12.765 7.8797 13.1289 7.5437 13.5797 7.5437H16.5908C17.0406 7.5437 17.4056 7.8797 17.4056 8.2937C17.4056 8.7077 17.0406 9.0437 16.5908 9.0437Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00717 17.7019C6.33413 17.7019 6.5981 17.9449 6.5981 18.2459C6.5981 18.5469 6.33413 18.7909 6.00717 18.7909C5.67911 18.7909 5.41515 18.5469 5.41515 18.2459C5.41515 17.9449 5.67911 17.7019 6.00717 17.7019Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00608 18.0408C5.88333 18.0408 5.78339 18.1328 5.78339 18.2458C5.78339 18.4728 6.22985 18.4728 6.22985 18.2458C6.22985 18.1328 6.12883 18.0408 6.00608 18.0408ZM6.00608 19.5408C5.23048 19.5408 4.60044 18.9598 4.60044 18.2458C4.60044 17.5318 5.23048 16.9518 6.00608 16.9518C6.78168 16.9518 7.4128 17.5318 7.4128 18.2458C7.4128 18.9598 6.78168 19.5408 6.00608 19.5408Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2607 17.7019C18.5876 17.7019 18.8527 17.9449 18.8527 18.2459C18.8527 18.5469 18.5876 18.7909 18.2607 18.7909C17.9326 18.7909 17.6686 18.5469 17.6686 18.2459C17.6686 17.9449 17.9326 17.7019 18.2607 17.7019Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2596 18.0408C18.1379 18.0408 18.038 18.1328 18.038 18.2458C18.0391 18.4748 18.4844 18.4728 18.4834 18.2458C18.4834 18.1328 18.3823 18.0408 18.2596 18.0408ZM18.2596 19.5408C17.484 19.5408 16.8539 18.9598 16.8539 18.2458C16.8539 17.5318 17.484 16.9518 18.2596 16.9518C19.0363 16.9518 19.6674 17.5318 19.6674 18.2458C19.6674 18.9598 19.0363 19.5408 18.2596 19.5408Z"/>
            
            <!-- Checkmark overlay -->
            <circle cx="19" cy="3" r="3" fill="#10B981" class="text-green-500"/>
            <path d="M17.5 4L19 5.5L21.5 3" stroke="white" stroke-width="1.5" fill="none" stroke-linecap="round"/>
        </svg>';
        // $unclaimedRewards = UserReward::where('status', 'unclaimed')->count();

        $metricCards = [
            // ['title' => $unclaimedRewards, 'subtitle' => 'Rewards Unclaimed', 'bgColor' => 'bg-green-600'],
            ['title' => $pendingRewards, 'subtitle' => 'Rewards Unclaimed', 'bgColor' => 'bg-yellow-600', 'svgIcon' => $pendingCartSvg],
            ['title' => $totalApprovedRewards, 'subtitle' => 'Total Rewards Claimed',  'bgColor' => 'bg-green-600','svgIcon' => $approvedCartSvg],
        ];

        $search = $request->input('search');
        $tier_level = $request->input('tier_level');
        $rewards = Reward::all();

        $userRewards = UserReward::with(['user', 'reward'])
           ->join('rewards', 'user_rewards.reward_id', '=', 'rewards.id')
           ->select('user_rewards.*')
           ->where('user_rewards.status', '!=', 'unclaimed')
           ->when($search, function ($query, $search) {
               $normalizedDate = null;

               try {
                   $timestamp = strtotime($search);
                   if ($timestamp !== false) {
                       $normalizedDate = date('Y-m-d', $timestamp);
                   }
               } catch (\Exception $e) {
                   $normalizedDate = null;
               }

               $query->where(function ($q) use ($search, $normalizedDate) {
                   $q->whereHas('user', function ($userQuery) use ($search) {
                       $userQuery->where('first_name', 'like', "%{$search}%")
                               ->orWhere('last_name', 'like', "%{$search}%");
                   })
                   ->orWhereHas('reward', function ($rewardQuery) use ($search) {
                       $rewardQuery->where('title', 'like', "%{$search}%");
                   });

                   if (preg_match('/^\d{4}-\d{2}$/', $search)) {
                       $q->orWhereBetween('user_rewards.achieved_at', [
                           "{$search}-01",
                           date('Y-m-t', strtotime($search . '-01')),
                       ]);
                   } elseif (!empty($normalizedDate)) {
                       $q->orWhereDate('user_rewards.achieved_at', $normalizedDate);
                   }
               });
           })
           ->when($request->input('tier_level'), function ($query, $tier_level) {
               $query->whereHas('reward', function ($rewardQuery) use ($tier_level) {
                   $rewardQuery->where('title', $tier_level);
               });
           })
           ->orderByRaw("FIELD(user_rewards.status, 'pending', 'claimed')")
           ->orderBy('rewards.priority', 'asc')
           ->paginate(1000)->appends($request->query());
           return view('admin.reward', compact('metricCards', 'userRewards', 'rewards'));
    }

    public function approveReward($id)
    {
        try {
            $userReward = UserReward::findOrFail($id);

            if ($userReward->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Reward not yet claimed.'
                ], 400);
            }

            $userReward->update(['status' => 'claimed']);

            return response()->json([
                'success' => true,
                'status'  => 'claimed',
                'message' => 'Reward Claimed.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function users(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('currentReward') // eager load for performance
            ->where('is_admin', false)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Basic text fields
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");

                    // Numeric or partial match fields
                    if (is_numeric($search)) {
                        $q->orWhere('bonus_point', $search)
                        ->orWhere('total_spent', $search);
                    } else {
                        // Handle fuzzy number search (e.g., "1000" matches "1000.50")
                        $q->orWhere('bonus_point', 'like', "%{$search}%")
                        ->orWhere('total_spent', 'like', "%{$search}%");
                    }

                    
                    $q->orWhereHas('currentReward', function ($tierQuery) use ($search) {
                        $tierQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(1000)
            ->appends($request->query());

        return view('admin.user', compact('users'));
    }


    public function showUser($id)
    {
        $user = User::find($id);
        return view('admin.profile-user', compact('user'));
    }

    


    public function profile()
    {
        return view('admin.profile');
    }

    public function settings()
    {
        return view('admin.setting');
    }

    public function uploads()
    {
        // Data for the four statistics cards at the top
        $statsData = [
            ['id' => 1, 'title' => "Post Pending Approval/Point", 'value' => "120", 'bgColor' => "bg-dashboard-purple"],
            ['id' => 2, 'title' => "Published Posts", 'value' => "393", 'bgColor' => "bg-dashboard-green"],
            ['id' => 3, 'title' => "Total Allocated Points", 'value' => "600,000", 'bgColor' => "bg-dashboard-green"],
            ['id' => 4, 'title' => "Uploads", 'value' => "69,088", 'bgColor' => "bg-dashboard-green"],
        ];

        // Data for the grid of upload cards
        $uploadCards = [
            [
                'id' => 1,
                'user' => ['name' => "Evan Yates", 'email' => "evanyates@gmail.com", 'avatar' => "https://api.builder.io/api/v1/image/assets/TEMP/0fcfed01b329364edf2a0ca0848dd16a0a5886dc?width=100"],
                'image' => "https://api.builder.io/api/v1/image/assets/TEMP/0fcfed01b329364edf2a0ca0848dd16a0a5886dc?width=300",
                'impressions' => "12k", 'bonusPoints' => 25, 'status' => "Approved",
                'content' => "hortinigeria_program We all love our stews and jollof, but have you ever wondered why sometimes a basket of tomatoes in Nigeria costs next to...",
                'hasVideo' => false, 'hasCarousel' => false,
            ],
            [
                'id' => 2,
                'user' => ['name' => "Evan Yates", 'email' => "evates@gmail.com", 'avatar' => "https://api.builder.io/api/v1/image/assets/TEMP/f2a594ecbf08800879bf571fa87f3490f4e75896?width=100"],
                'image' => "https://api.builder.io/api/v1/image/assets/TEMP/f2a594ecbf08800879bf571fa87f3490f4e75896?width=300",
                'impressions' => "12k", 'bonusPoints' => 25, 'status' => "Approved",
                'content' => "hortinigeria_program We all love our stews and jollof, but have you ever wondered why sometimes a basket of tomatoes in Nigeria costs next to...",
                'hasVideo' => true, 'hasCarousel' => false,
            ],
            [
                'id' => 4,
                'user' => ['name' => "Evan Yates", 'email' => "enyates@gmail.com", 'avatar' => "https://api.builder.io/api/v1/image/assets/TEMP/98a432b31fe6c3070dfb68bab5b3d7b53437fa41?width=100"],
                'image' => "https://api.builder.io/api/v1/image/assets/TEMP/98a432b31fe6c3070dfb68bab5b3d7b53437fa41?width=300",
                'impressions' => "12k", 'bonusPoints' => 25, 'status' => "Approved",
                'content' => "hortinigeria_program We all love our stews and jollof, but have you ever wondered why sometimes a basket of tomatoes in Nigeria costs next to...",
                'hasVideo' => false, 'hasCarousel' => true,
            ],
            // Add other card data here...
        ];

        // Data for the user requests table
        $tableData = [
            ['id' => 1, 'sn' => '01', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'pending'],
            ['id' => 2, 'sn' => '02', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'approved'],
            ['id' => 3, 'sn' => '03', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'pending'],
            ['id' => 4, 'sn' => '04', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => '89', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'approved'],
            ['id' => 5, 'sn' => '05', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'declined'],
            ['id' => 6, 'sn' => '06', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'pending'],
        ];

        return view('admin.uploads', compact('statsData', 'uploadCards', 'tableData'));
    }

    public function uploadRequests()
    {
        $statsData = [
            ['id' => 1, 'title' => "Post Pending Approval/Point", 'value' => "120", 'bgColor' => "bg-dashboard-purple"],
            ['id' => 2, 'title' => "Published Posts", 'value' => "393", 'bgColor' => "bg-dashboard-green"],
            ['id' => 3, 'title' => "Total Allocated Points", 'value' => "600,000", 'bgColor' => "bg-dashboard-green"],
            ['id' => 4, 'title' => "Uploads", 'value' => "69,088", 'bgColor' => "bg-dashboard-green"],
        ];


        $uploadCards = [
            [
                'id' => 1,
                'user' => ['name' => "Evan Yates", 'email' => "evanyates@gmail.com", 'avatar' => "https://api.builder.io/api/v1/image/assets/TEMP/0fcfed01b329364edf2a0ca0848dd16a0a5886dc?width=100"],
                'image' => "https://api.builder.io/api/v1/image/assets/TEMP/0fcfed01b329364edf2a0ca0848dd16a0a5886dc?width=300",
                'impressions' => "12k", 'bonusPoints' => 25, 'status' => "Approved",
                'content' => "hortinigeria_program We all love our stews and jollof, but have you ever wondered why sometimes a basket of tomatoes in Nigeria costs next to...",
                'hasVideo' => false, 'hasCarousel' => false,
            ],
            [
                'id' => 2,
                'user' => ['name' => "Evan Yates", 'email' => "evates@gmail.com", 'avatar' => "https://api.builder.io/api/v1/image/assets/TEMP/f2a594ecbf08800879bf571fa87f3490f4e75896?width=100"],
                'image' => "https://api.builder.io/api/v1/image/assets/TEMP/f2a594ecbf08800879bf571fa87f3490f4e75896?width=300",
                'impressions' => "12k", 'bonusPoints' => 25, 'status' => "Approved",
                'content' => "hortinigeria_program We all love our stews and jollof, but have you ever wondered why sometimes a basket of tomatoes in Nigeria costs next to...",
                'hasVideo' => true, 'hasCarousel' => false,
            ],
            [
                'id' => 4,
                'user' => ['name' => "Evan Yates", 'email' => "enyates@gmail.com", 'avatar' => "https://api.builder.io/api/v1/image/assets/TEMP/98a432b31fe6c3070dfb68bab5b3d7b53437fa41?width=100"],
                'image' => "https://api.builder.io/api/v1/image/assets/TEMP/98a432b31fe6c3070dfb68bab5b3d7b53437fa41?width=300",
                'impressions' => "12k", 'bonusPoints' => 25, 'status' => "Approved",
                'content' => "hortinigeria_program We all love our stews and jollof, but have you ever wondered why sometimes a basket of tomatoes in Nigeria costs next to...",
                'hasVideo' => false, 'hasCarousel' => true,
            ],
            // Add other card data here...
        ];


        $tableData = [
            ['id' => 1, 'sn' => '01', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'pending'],
            ['id' => 2, 'sn' => '02', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'approved'],
            ['id' => 3, 'sn' => '03', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'pending'],
            ['id' => 4, 'sn' => '04', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => '89', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'approved'],
            ['id' => 5, 'sn' => '05', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'declined'],
            ['id' => 6, 'sn' => '06', 'name' => 'Sodiq Tajudeen', 'postId' => 'FY25278U83', 'bonusPoint' => 'Nil', 'dateCreated' => '20-02-2025 | 09:33pm', 'status' => 'pending'],
        ];

        return view('admin.upload-requests', compact('statsData', 'uploadCards', 'tableData'));
    }
}
