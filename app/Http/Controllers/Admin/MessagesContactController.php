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
                $q->whereBetween('created_at', [
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
            'user_ids' => [],
        ]);

        $this->auditLogService->log(
            'create_contact_list',
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
        $savedUserIds = $contactList->user_ids ?? [];
        
        // Merge with any temporary selections from request (for validation errors)
        $selectedUserIds = collect($savedUserIds)
            ->merge($request->input('user_ids', []))
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
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'integer|distinct|exists:users,id',
        ]);

        DB::beginTransaction();

        try {
            $contactList = MessageContact::findOrFail($id);
            $oldData = $contactList->toArray();

            $contactList->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'user_ids' => array_unique($validatedData['user_ids'] ?? []),
            ]);

            $contactList->refresh();

            $this->auditLogService->log(
                'update_contact_list',
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
            $query->whereBetween('created_at', [
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
        $query = UserReward::query()
            ->with(['user', 'reward']); // eager load both sides

        if ($request->filled('reward_id')) {
            $query->where('reward_id', (int) $request->input('reward_id'));
        }

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [
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

        $query->where(function ($q) {
            $q->where('status', '!=', 'claimed')                   // include unclaimed normally
            ->orWhereIn('id', function ($sub) {                  // but include only the highest claimed
                    $sub->selectRaw('MAX(id)')
                        ->from('user_rewards')
                        ->whereColumn('user_id', 'user_rewards.user_id')
                        ->where('status', 'claimed');
                });
        });

        // Order by user first name
        $records = $query->get()->sortBy(fn($ur) => $ur->user->first_name)
            ->map(function ($ur) {
                return [
                    'user_id' => $ur->user_id,
                    'full_name' => $ur->user->full_name,
                    'email' => $ur->user->email,
                    'tier_level' => $ur->reward->title,
                    'achieved_at' => $ur->achieved_at,
                    'status' => $ur->status,
                ];
            })
            ->values(); // reset keys

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
        $query = User::query()
            ->where('is_admin', false);

        // search on users
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // reward filters on pivot
        if ($request->filled('reward_id') || $request->filled(['start_date', 'end_date'])) {
            $query->whereHas('userRewards', function ($q) use ($request) {

                if ($request->filled('reward_id')) {
                    $q->where('reward_id', (int) $request->input('reward_id'));
                }

                if ($request->filled(['start_date', 'end_date'])) {
                    $q->whereBetween('created_at', [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ]);
                }
            });
        }

        // total count of unique users in the filtered set
        $total = $query->distinct()->count('users.id');

        // last updated timestamp among those filtered users
        $lastUpdated = $query->max('updated_at');

        return response()->json([
            'total' => $total,
            'last_updated' => $lastUpdated
                ? \Carbon\Carbon::parse($lastUpdated)->toIsoString()
                : null,
        ]);
    }



}
