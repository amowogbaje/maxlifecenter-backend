<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\MessageContact;
use App\Models\User;
use App\Models\UserReward;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Services\AuditLogService;
use Auth;
use DB;
use Log;

use App\Models\Reward;
use Carbon\Carbon;

class MessagesContactController extends Controller
{

    private AuditLogService $auditLogService;

    public function __construct(AuditLogService $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }

    public function index()
    {
        $noOfContactList = Message::count();
        $noOfMessageTemplates = Message::count();
        $messageLogCount = Message::count();


        $metricCards = [
            ['title' => $noOfMessageTemplates, 'subtitle' => 'Total Message Templates', 'bgColor' => 'bg-green-600', 'svgIcon' => '<i class="fi fi-tr-envelopes text-white"></i>', 'routeName' => 'admin.messages.templates.index'],
            ['title' => $noOfContactList, 'subtitle' => 'Total Contact List',  'bgColor' => 'bg-green-600', 'svgIcon' => '<i class="fi fi-tr-address-book text-white"></i>', 'routeName' => 'admin.messages.templates.index'],
            ['title' => $messageLogCount, 'subtitle' => 'Total Messages Sent',  'bgColor' => 'bg-green-600', 'svgIcon' => '<i class="fi fi-tr-newsletter-subscribe text-white"></i>', 'routeName' => 'admin.messages.templates.index'],
        ];




        return view('admin.messages.index', compact('metricCards'));
    }

    public function contacts()
    {
        $contacts = MessageContact::paginate(10);

        return view('admin.messages.contacts.index', compact('contacts'));
    }

    public function create(Request $request)
    {
        $query = User::query();
        $query->where('is_admin', false);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($rewardId = $request->input('reward_id')) {
            $query->whereHas('rewards', function ($q) use ($rewardId) {
                $q->where('reward_id', $rewardId);
            });
        }

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereHas('userRewards', function ($q) use ($request) {
                $q->whereBetween('achieved_at', [
                    $request->input('start_date'),
                    $request->input('end_date'),
                ]);
            });
        }


        $users = $query->paginate(10);
        $rewards = Reward::all();
        return view('admin.messages.contacts.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $contactList = MessageContact::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'contact_ids' => [],
        ]);

        $this->auditLogService->log(
            'create_subscription',
            $contactList,
            ['old' => [], 'new' => $contactList],
            'Contact list created'
        );

        return redirect()->route('admin.messages.contacts.edit', $contactList->id)
            ->with('success', 'Contact list created successfully! Add Users here');
    }

    public function edit(Request $request, $id)
    {
        $contactList = MessageContact::findOrFail($id);

        // Get previously saved user IDs
        $savedUserIds = $contactList->contact_ids ?? [];
        
        // Merge with any temporary selections from request (for validation errors)
        $selectedUserIds = collect($savedUserIds)
            ->merge($request->input('contact_ids', []))
            ->unique()
            ->values()
            ->toArray();
        
        $rewards = Reward::all();

        return view('admin.messages.contacts.edit', compact('rewards', 'contactList', 'selectedUserIds'));
    }

    public function update(Request $request, $id)
    {
        // Validate request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'contact_ids' => 'nullable|array',
            'contact_ids.*' => 'integer|distinct|exists:users,id',
        ]);

        DB::beginTransaction();

        try {
            $contactList = MessageContact::findOrFail($id);
            $oldData = $contactList->toArray();

            $contactList->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'contact_ids' => array_unique($validatedData['contact_ids'] ?? []),
            ]);

            $contactList->refresh();

            $this->auditLogService->log(
                'update_subscription',
                $contactList,
                ['old' => $oldData, 'new' => $contactList->toArray()],
                Auth::guard('admin')->id(),
                'Contact list updated'
            );

            DB::commit();

            return redirect()
                ->route('admin.messages.contacts.index')
                ->with('success', 'Contact list updated successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Contact list not found', [
                'id' => $id,
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('admin.messages.contacts.index')
                ->with('error', 'Contact list not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update contact list', [
                'id' => $id,
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update contact list. Please try again.');
        }
    }

    public function fetchUsers(Request $request)
    {
        $offset = (int) $request->get('offset', 0);
        $limit = (int) $request->get('limit', 100);

        $query = UserReward::query()
            ->with(['user', 'reward']); // eager load both sides

        if ($request->filled('reward_id')) {
            $query->where('reward_id', (int) $request->input('reward_id'));
        }

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('achieved_at', [
                $request->input('start_date'),
                $request->input('end_date'),
            ]);
        }

        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $records = $query->orderBy('id')
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->map(function ($ur) {
                return [
                    'user_id' => $ur->user_id,
                    'full_name' => $ur->user->full_name,
                    'email' => $ur->user->email,
                    'tier_level' => $ur->reward->title,
                    'achieved_at' => $ur->achieved_at,
                    'status' => $ur->status,
                ];
            });

        return response()->json($records);
    }

    public function fetchAll(Request $request)
{
    $rewardIdSelected = $request->filled('reward_id');
    $dateFilterSelected = $request->filled(['start_date', 'end_date']);
    $search = $request->input('search');
    $rewardId = $rewardIdSelected ? (int) $request->input('reward_id') : null;

    /**
     * STEP 1 — base query (NO reward_id filter yet)
     */
    $query = UserReward::query()->with(['user', 'reward']);

    // SEARCH
    if ($search) {
        $query->whereHas('user', function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // DATE FILTER
    if ($dateFilterSelected) {
        $query->whereBetween('achieved_at', [
            $request->input('start_date'),
            $request->input('end_date'),
        ]);
    }

    // STEP 2 — fetch all (we need all to compute highest rewards)
    $records = $query->get();
    $countRecords = $query->count();


    /**
     * RULE 1:
     * If ONLY reward_id is selected (NO dates):
     *     Show ONLY users whose HIGHEST reward == reward_id
     */
    if ($rewardIdSelected && !$dateFilterSelected) {

        // Group all rewards by user
        $records = $records->groupBy('user_id')
            ->map(function ($userRewards) use ($rewardId) {

                // Highest reward for this user
                $highest = $userRewards->sortByDesc('reward_id')->first();

                // include only if highest reward matches the requested reward
                return $highest->reward_id == $rewardId ? $highest : null;

            })
            ->filter()   // remove nulls
            ->values();
    }

    /**
     * RULE 2:
     * If reward_id + date filter:
     *     Apply reward filter normally
     */
    if ($rewardIdSelected && $dateFilterSelected) {
        $records = $records->filter(function ($ur) use ($rewardId) {
            return $ur->reward_id == $rewardId;
        })->values();
    }

    /**
     * RULE 3:
     * If no reward_id → normal behavior
     * (records untouched)
     */

    // Format final output
    $records = $records
        ->sortBy(fn($ur) => $ur->user->first_name)
        ->map(function ($ur) {
            return [
                'user_id'     => $ur->user_id,
                'full_name'   => $ur->user->full_name,
                'email'       => $ur->user->email,
                'tier_level'  => $ur->reward->title,
                'achieved_at' => $ur->achieved_at,
                'status'      => $ur->status,
            ];
        })
        ->values();

    // return response()->json($countRecords);
    return response()->json($records);

}




    public function fetchAllAlt(Request $request)
    {
        return UserReward::query()
            ->with(['user', 'reward'])
            ->when($request->reward_id, fn($q) => $q->where('reward_id', $request->reward_id))
            ->get()
            ->map(fn($r) => $r->user);
    }





    // Return metadata: total count and last_updated timestamp (simple check)
    public function meta(Request $request)
    {
        $search   = $request->input('search');
        $rewardId = $request->input('reward_id');
        $dates    = $request->filled(['start_date', 'end_date']);
        $onlyRewardFilter = $request->filled('reward_id') && !$dates;

        // Start from UserReward model for accuracy
        $query = UserReward::query()->with('user');

        // SEARCH on user
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // DATE FILTER
        if ($dates) {
            $query->whereBetween('achieved_at', [
                $request->input('start_date'),
                $request->input('end_date'),
            ]);

            if ($rewardId) {
                $query->where('reward_id', (int)$rewardId);
            }
        }

        // ONLY reward_id → highest reward logic
        if ($onlyRewardFilter) {
            $query->whereIn('user_id', function ($sub) use ($rewardId) {
                $sub->from('user_rewards')
                    ->select('user_id')
                    ->groupBy('user_id')
                    ->havingRaw('MAX(reward_id) = ?', [$rewardId]);
            });
        }

        // If only reward_id + no dates → still ensure reward filtering
        if ($rewardId && !$dates) {
            // no direct filter here because highest-reward logic handles it
        }

        // Count unique users
        $total = $query->distinct('user_id')->count('user_id');

        // last_updated from users table
        $lastUpdated = User::whereIn('id', $query->pluck('user_id'))
            ->max('updated_at');

        return response()->json([
            'total'        => $total,
            'last_updated' => $lastUpdated
                ? \Carbon\Carbon::parse($lastUpdated)->toIsoString()
                : null,
        ]);
    }





}
