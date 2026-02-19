<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\Subscription;
use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;
use App\Services\AuditLogService;
use Auth;
use DB;
use Log;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Mail; 
use App\Mail\VerifySubscriptionEmail;

use Carbon\Carbon;

class SubscriptionController extends Controller
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
        $subscriptions = Subscription::paginate(10);

        return view('admin.messages.subscriptions.index', compact('subscriptions'));
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

        

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [
                $request->input('start_date'),
                $request->input('end_date'),
            ]);
        }


        $users = $query->paginate(10);
        return view('admin.messages.subscriptions.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $contactList = Subscription::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
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
        $subscription = Subscription::findOrFail($id);

        $contacts = $subscription->contacts()->paginate(25);

        return view(
            'admin.messages.subscriptions.edit',
            compact('subscription', 'contacts')
        );
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
            $contactList = Subscription::findOrFail($id);
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

    public function fetchContacts(Request $request)
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

    public function subscribe(Request $request, Subscription $subscription): JsonResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $name = trim($validated['name'] ?? '');

            [$firstName, $lastName] = array_pad(
                preg_split('/\s+/', $name, 2),
                2,
                null
            );

            $contact = Contact::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'phone'      => $validated['phone'] ?? null,
                ]
            );

            // If email exists and not verified → cache & send email
            if ($contact->email && !$contact->email_verified_at) {

                $token = (string) Str::uuid();

                Cache::put(
                    "subscription_verify:{$token}",
                    [
                        'subscription_id' => $subscription->id,
                        'contact_id'      => $contact->id,
                    ],
                    now()->addMinutes(30)
                );

                Mail::to($contact->email)->send(
                    new VerifySubscriptionEmail($token, $subscription)
                );

                DB::commit();

                return response()->json([
                    'message' => 'Verification email sent. Please confirm to complete subscription.',
                ], Response::HTTP_ACCEPTED);
            }

            // Attach immediately if no email OR already verified
            $subscription->contacts()->syncWithoutDetaching([$contact->id]);

            DB::commit();

            return response()->json([
                'message' => 'Subscribed successfully',
                'data' => [
                    'subscription' => $subscription,
                    'contact' => $contact,
                ],
            ], Response::HTTP_CREATED);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'message' => 'Subscription failed',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verify(string $token): JsonResponse
    {
        $cacheKey = "subscription_verify:{$token}";

        $data = Cache::get($cacheKey);

        if (!$data) {
            return response()->json([
                'message' => 'Invalid or expired verification link',
            ], Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();

        try {
            $contact = Contact::findOrFail($data['contact_id']);
            $subscription = Subscription::findOrFail($data['subscription_id']);

            $contact->update([
                'email_verified_at' => now(),
            ]);

            $subscription->contacts()->syncWithoutDetaching([$contact->id]);

            Cache::forget($cacheKey);

            DB::commit();

            return response()->json([
                'message' => 'Email verified and subscription completed',
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'message' => 'Verification failed',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     public function unsubscribe(Request $request, Subscription $subscription): JsonResponse
    {
        $validated = $request->validate([
            'contact_id' => ['required', 'exists:contacts,id'],
        ]);

        $contactId = $validated['contact_id'];

        // Optional: ownership check
        if ($subscription->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $subscription->contacts()->detach($contactId);

            return response()->json([
                'message' => 'Contact unsubscribed successfully',
                'data' => [
                    'subscription_id' => $subscription->id,
                    'contact_id' => $contactId,
                    'contacts_count' => $subscription->contacts()->count(),
                ]
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Failed to unsubscribe contact'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



}
