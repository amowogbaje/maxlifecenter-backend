<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\MessageContact;
use App\Models\Contact;
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

    public function subscriptions()
    {
        $subscriptions = MessageContact::paginate(10);

        return view('admin.messages.contacts.index', compact('subscriptions'));
    }

    public function create(Request $request)
    {
        $query = Contact::query();

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
            $query->whereBetween('achieved_at', [
                $request->input('start_date'),
                $request->input('end_date'),
            ]);
        }


        $users = $query->paginate(10);
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

        return redirect()->route('admin.messages.subscriptions.edit', $contactList->id)
            ->with('success', 'Subscription list created successfully! Add Users here');
    }

    public function edit(Request $request, $id)
    {
        $subscription = MessageContact::findOrFail($id);

        // Get previously saved user IDs
        $savedUserIds = $subscription->contact_ids ?? [];
        
        // Merge with any temporary selections from request (for validation errors)
        $selectedUserIds = collect($savedUserIds)
            ->merge($request->input('contact_ids', []))
            ->unique()
            ->values()
            ->toArray();
        
        

        return view('admin.messages.contacts.edit', compact('subscription', 'selectedUserIds'));
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
                'Subscription list updated'
            );

            DB::commit();

            return redirect()
                ->route('admin.messages.subscriptions.index')
                ->with('success', 'Subscription list updated successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Subscription list not found', [
                'id' => $id,
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('admin.messages.subscriptions.index')
                ->with('error', 'Subscription list not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update subscription list', [
                'id' => $id,
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update subscription list. Please try again.');
        }
    }

    public function fetchUsers(Request $request)
    {
        $offset = (int) $request->get('offset', 0);
        $limit  = min((int) $request->get('limit', 100), 100);

        $query = Contact::query();

        // Date filter
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ]);
        }

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $records = $query
            ->orderBy('id')
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->map(fn (Contact $contact) => [
                'user_id'     => $contact->id,
                'full_name'   => $contact->full_name, // accessor or computed
                'email'       => $contact->email,
                'created_at'  => $contact->created_at,
            ]);

        return response()->json($records);
    }


    public function fetchAll(Request $request)
    {
        $dateFilterSelected = $request->filled(['start_date', 'end_date']);
        $search             = $request->input('search');

        /**
         * STEP 1 — Base User query
         */
        $query = Contact::query();

        /**
         * SEARCH
         */
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /**
         * DATE FILTER
         * Applied ONLY when explicitly requested
         */
        if ($dateFilterSelected) {
            $query->whereBetween('created_at', [
                $request->input('start_date'),
                $request->input('end_date'),
            ]);
        }

        /**
         * STEP 2 — Fetch users
         */
        $records = $query
            ->orderBy('first_name')
            ->get()
            ->map(fn (Contact $contact) => [
                'user_id'     => $contact->id,
                'full_name'   => $contact->full_name,
                'email'       => $contact->email,
                'created_at'  => $contact->created_at,
            ]);

        return response()->json($records);
    }





    public function fetchAllAlt(Request $request)
    {
        return Contact::query()
            ->get()
            ->map(fn($r) => $r->user);
    }





    // Return metadata: total count and last_updated timestamp (simple check)
    public function meta(Request $request)
    {
        $search   = $request->input('search');

        $dates = $request->filled(['start_date', 'end_date']);

        /**
         * STEP 1 — Base User query
         */
        $query = Contact::query();

        /**
         * SEARCH
         */
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /**
         * DATE FILTER
         */
        if ($dates) {
            $query->whereBetween('created_at', [
                $request->input('start_date'),
                $request->input('end_date'),
            ]);
        }

        

        /**
         * META CALCULATIONS
         */
        $total = (clone $query)->count();

        $lastUpdated = (clone $query)->max('updated_at');

        return response()->json([
            'total'        => $total,
            'last_updated' => $lastUpdated
                ? \Carbon\Carbon::parse($lastUpdated)->toIsoString()
                : null,
        ]);
    }



}
