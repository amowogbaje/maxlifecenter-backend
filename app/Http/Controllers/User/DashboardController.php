<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductOnSale;
use App\Models\UserReward;
use App\Services\WooCommerceService;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    private WooCommerceService $wooCommerceService;

    public function __construct(WooCommerceService $wooCommerceService) {
        $this->wooCommerceService = $wooCommerceService;
    }
    public function index()
    {
        $rewardIcon = '<svg class="w-4 h-4 text-white" viewBox="0 0 12 12" fill="currentColor"><path d="M2.25 1C1.56 1 1 1.56 1 2.25V3.412C1.00027 3.67934 1.07198 3.94175 1.20771 4.17207C1.34344 4.40239 1.53826 4.59225 1.772 4.722L4.648 6.321C4.0456 6.62512 3.56332 7.12345 3.27909 7.73549C2.99486 8.34752 2.92528 9.03751 3.08159 9.69398C3.2379 10.3504 3.61097 10.935 4.14052 11.3533C4.67008 11.7716 5.32518 11.9991 6 11.9991C6.67482 11.9991 7.32992 11.7716 7.85948 11.3533C8.38903 10.935 8.7621 10.3504 8.91841 9.69398C9.07472 9.03751 9.00514 8.34752 8.72091 7.73549C8.43668 7.12345 7.9544 6.62512 7.352 6.321L10.229 4.723C10.4627 4.59304 10.6574 4.40297 10.793 4.17246C10.9285 3.94196 11 3.67941 11 3.412V2.25C11 1.56 10.44 1 9.75 1H2.25ZM5 5.372V2H7V5.372L6 5.928L5 5.372ZM8 9C8 9.53043 7.78929 10.0391 7.41421 10.4142C7.03914 10.7893 6.53043 11 6 11C5.46957 11 4.96086 10.7893 4.58579 10.4142C4.21071 10.0391 4 9.53043 4 9C4 8.46957 4.21071 7.96086 4.58579 7.58579C4.96086 7.21071 5.46957 7 6 7C6.53043 7 7.03914 7.21071 7.41421 7.58579C7.78929 7.96086 8 8.46957 8 9Z"/></svg>';
        $usersIcon = '<svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12C14.21 12 16 10.21 16 8S14.21 4 12 4 8 5.79 8 8 9.79 12 12 12M12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"/></svg>';
        $user = auth()->user();
        $purchaseCount = Order::where('user_id', $user->id)->count();
        $purchaseTotal = Order::where('user_id', $user->id)->sum('total');
        $currentTier = $user->approvedTier->title;
        $nextTier = $user->nextToBeApprovedTier?->title ?? null;
        $recentProducts = ProductOnSale::latest()->take(6)->get();
        $data = compact('purchaseCount', 'purchaseTotal','currentTier', 'nextTier', 'recentProducts');

        return view('user.dashboard', $data);
    }

    public function fetchSalesProducts()
    {
        $recentProducts = $this->wooCommerceService->fetchProductsOnSales();

        return response()->json($recentProducts);
    }



    public function purchases()
    {
        $purchases = auth()->user()
            ->orders()
            ->orderBy('date_created', 'desc') 
            ->paginate(10);

        return view('user.purchase', compact('purchases'));
    }

    public function showPurchase($id) {
        $purchase = Order::with(['items.product'])->find($id);
        $user = auth()->user();
        return view('user.purchase-details', compact('purchase', 'user'));
    }

    public function rewards()
    {
        $user = User::find(auth()->user()->id);
        $rewards = $user->rewards()
        ->withPivot(['id','status', 'mail_sent']) // include pivot fields
        ->where('user_rewards.status', 'claimed')
        ->orderBy('user_rewards.created_at', 'desc')
        ->get([
            'rewards.id',
            'rewards.code',        // PN0001265
            'rewards.title',       // Reward Title
            'rewards.description', // Description text
            'rewards.created_at',
        ]);

        // return $rewards;

        return view('user.reward', compact('user','rewards'));
    }

    public function claimReward($id)
    {
        try {
            $userReward = UserReward::findOrFail($id);

            if ($userReward->status !== 'unclaimed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Reward already claimed or processed.'
                ], 400);
            }

            $userReward->update(['status' => 'pending']);

            return response()->json([
                'success' => true,
                'status'  => 'pending',
                'message' => 'Reward moved to pending approval.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function users()
    {



        $users = [
            ['name' => 'Eves Yate', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'tier' => 'Oloye'],
            ['name' => 'Eves Yate', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'tier' => 'Balogun'],
            ['name' => 'Eves Yate', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'tier' => 'Kabiyesi'],
            ['name' => 'Eves Yate', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'tier' => 'Eleniyan'],
            ['name' => 'Eves Yate', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'tier' => 'Oloye'],
            ['name' => 'Eves Yate', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'tier' => 'Balogun'],
        ];

        return view('user.user', compact('users'));
    }

    public function updates()
    {
        $metricCards = [
            ['title' => '600,000', 'subtitle' => 'Total Point Allocation', 'bgColor' => 'bg-green-600'],
            ['title' => '393', 'subtitle' => 'Reward Rate',  'bgColor' => 'bg-green-600'],
            ['title' => '69,088', 'subtitle' => 'Uploads',  'bgColor' => 'bg-green-600'],
        ];


        $updates = [
            ['title' => 'New app build release', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'segment' => 'Oloye'],
            ['title' => 'New app build release', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'segment' => 'Balogun'],
            ['title' => 'New app build release', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'segment' => 'Kabiyesi'],
            ['title' => 'New app build release', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'segment' => 'Eleniyan'],
            ['title' => 'New app build release', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'segment' => 'Oloye'],
            ['title' => 'New app build release', 'bonus_point' => 30,  'date' => 'Apr 12, 1995 23:06 pm', 'id' => 'JD257HYD373', 'segment' => 'Balogun'],
        ];

        return view('user.updates', compact('metricCards','updates'));
    }


    public function profile()
    {
        return view('user.profile');
    }

    public function updateProfile(Request $request)
    {
        $user =  $user = User::find($request->user_id);;
        
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

        $user->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
        ]);
    }


    public function settings()
    {
        return view('user.setting');
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

        return view('user.uploads', compact('statsData', 'uploadCards', 'tableData'));
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

        return view('user.upload-requests', compact('statsData', 'uploadCards', 'tableData'));
    }
}
