<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;
use App\Models\Admin;
use App\Models\AuditLog;
use Carbon\Carbon; 

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $rewardIcon = '<svg class="w-4 h-4 text-white" viewBox="0 0 12 12" fill="currentColor"><path d="M2.25 1C1.56 1 1 1.56 1 2.25V3.412C1.00027 3.67934 1.07198 3.94175 1.20771 4.17207C1.34344 4.40239 1.53826 4.59225 1.772 4.722L4.648 6.321C4.0456 6.62512 3.56332 7.12345 3.27909 7.73549C2.99486 8.34752 2.92528 9.03751 3.08159 9.69398C3.2379 10.3504 3.61097 10.935 4.14052 11.3533C4.67008 11.7716 5.32518 11.9991 6 11.9991C6.67482 11.9991 7.32992 11.7716 7.85948 11.3533C8.38903 10.935 8.7621 10.3504 8.91841 9.69398C9.07472 9.03751 9.00514 8.34752 8.72091 7.73549C8.43668 7.12345 7.9544 6.62512 7.352 6.321L10.229 4.723C10.4627 4.59304 10.6574 4.40297 10.793 4.17246C10.9285 3.94196 11 3.67941 11 3.412V2.25C11 1.56 10.44 1 9.75 1H2.25ZM5 5.372V2H7V5.372L6 5.928L5 5.372ZM8 9C8 9.53043 7.78929 10.0391 7.41421 10.4142C7.03914 10.7893 6.53043 11 6 11C5.46957 11 4.96086 10.7893 4.58579 10.4142C4.21071 10.0391 4 9.53043 4 9C4 8.46957 4.21071 7.96086 4.58579 7.58579C4.96086 7.21071 5.46957 7 6 7C6.53043 7 7.03914 7.21071 7.41421 7.58579C7.78929 7.96086 8 8.46957 8 9Z"/></svg>';
        $usersIcon = '<svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12C14.21 12 16 10.21 16 8S14.21 4 12 4 8 5.79 8 8 9.79 12 12 12M12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"/></svg>';
        $totalUsersCount = Contact::count();

        

        $metricCards = [
            ['title' => $totalUsersCount, 'subtitle' => 'Users',  'bgColor' => 'bg-success', 'icon' => $usersIcon, 'hasAvatar' => false],
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

    
}
