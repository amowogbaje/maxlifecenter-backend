<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\MessageContact;
use App\Models\AuditLog;
use App\Models\User;
use App\Mail\GenericMessageMail;
use App\Mail\GenericTestMessageMail;
use App\Models\Reward;
use App\Services\AuditLogService;
use Carbon\Carbon;
use Auth;

class MessagesController extends Controller
{
    private AuditLogService $auditLogService;

    public function __construct(AuditLogService $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }
    public function index()
    {
        $noOfContactList = MessageContact::count();
        $noOfMessageTemplates = Message::count();
        $messageLogCount = AuditLog::whereIn('model_type', [
            Message::class,
            MessageContact::class,
        ])->count();


        $metricCards = [
            ['title' => $noOfMessageTemplates, 'subtitle' => 'Total Message Templates', 'bgColor' => 'bg-green-600', 'svgIcon' => '<i class="fi fi-tr-envelopes text-white"></i>', 'routeName' => 'admin.messages.templates.index'],
            ['title' => $noOfContactList, 'subtitle' => 'Total Contact List',  'bgColor' => 'bg-green-600', 'svgIcon' => '<i class="fi fi-tr-address-book text-white"></i>', 'routeName' => 'admin.messages.contacts.index'],
            ['title' => $messageLogCount, 'subtitle' => 'Messages Logs',  'bgColor' => 'bg-green-600', 'svgIcon' => '<i class="fi fi-tr-newsletter-subscribe text-white"></i>', 'routeName' => 'admin.messages.logs.index'],
        ];




        return view('admin.messages.index', compact('metricCards'));
    }

    public function templates()
    {
        $messages = Message::all();
        return view('admin.messages.templates.index', compact('messages'));
    }

    public function create()
    {
        return view('admin.messages.templates.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        // Generate slug from title
        $slug = Str::slug($request->title);

        // Ensure uniqueness
        $count = Message::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        Message::create([
            'title'   => $request->title,
            'slug'    => $slug,
            'subject' => $request->subject,
            'body'    => $request->body,
        ]);

        // 📝 Audit log entry
        $this->auditLogService->log(
            action: 'create',
            model: $message,
            data: ['new' => $message->toArray()],
            description: 'Created a new message template'
        );

        return redirect()->route('admin.messages.templates.index')
            ->with('success', 'Message template created successfully.');
    }


    public function preview(Message $message, Request $request)
    {

        $rewardLevels = Reward::all();
        $contactLists = MessageContact::select('id', 'title', 'user_ids')->orderBy('title')->get();


        return view('admin.messages.templates.preview', compact('message', 'contactLists', 'rewardLevels'));
    }

    public function previewOld(Message $message, Request $request)
    {
        $rewardLevel = $request->input('reward_level');
        $rewardLevels = Reward::all();

        $users = User::where('current_reward_id', $rewardLevel)->get();

        return view('admin.messages.templates.preview-old', compact('message', 'users', 'rewardLevel', 'rewardLevels'));
    }

    public function send(Request $request, Message $message)
    {
        $validated = $request->validate([
            'send_mode'       => 'required|in:contact_list,custom',
            'contact_list_id' => 'nullable|exists:message_contacts,id',
            'recipient_type'  => 'nullable|in:all,reward_level,individual',
            'reward_level'    => 'nullable|exists:rewards,id',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'users'           => 'nullable|array',
            'users.*'         => 'exists:users,id',
        ]);

        try {
            $users = collect();
            $logDetails = [];

            // Execute the right handler and populate $users and $logDetails
            match ($validated['send_mode']) {
                'contact_list' => $this->handleContactList($validated, $users, $logDetails, $message),
                'custom' => $this->handleCustomMode($validated, $users, $logDetails, $message),
            };

            if ($users->isEmpty()) {
                return back()->with('error', 'No users found for the selected mode.');
            }

            // Queue mail to users
            \Log::info('Users:'. json_encode($users));
            foreach ($users as $user) {
                \Mail::to($user->email)->send(new GenericMessageMail($message, $user));
            }

            // Audit log - use your audit service
            $this->auditLogService->log(
                action: 'send_message',
                model: $message,
                data: ['new' => $logDetails],
                description: 'Message sent'
            );

            return back()->with('success', "Message sent successfully to {$users->count()} users.");
        } catch (\Throwable $e) {
            \Log::error('Message Send Error: ' . $e->getMessage(), [
                'exception' => $e,
                'validated' => $validated,
                'message_id' => $message->id ?? null,
            ]);

            return back()->with('error', $e->getMessage());
        }
    }

    private function handleContactList(array $validated, &$users, &$logDetails, Message $message): void
    {
        if (empty($validated['contact_list_id'])) {
            throw new \Exception('Contact list not provided.');
        }

        $contactList = MessageContact::findOrFail($validated['contact_list_id']);
        $userIds = $contactList->user_ids ?? [];

        if (empty($userIds)) {
            throw new \Exception('The selected contact list has no users.');
        }

        $users = User::whereIn('id', $userIds)->get();

        $logDetails = [
            'send_mode' => 'contact_list',
            'contact_list' => $contactList->only(['id', 'title']),
            'recipients' => $users->pluck('email')->toArray(),
            'message_id' => $message->id,
            'message_subject' => $message->subject,
        ];
    }

    private function handleCustomMode(array $validated, &$users, &$logDetails, Message $message): void
    {
        $recipientType = $validated['recipient_type'] ?? 'all';

        $users = match ($recipientType) {
            'all' => User::where('is_admin', false)->get(),

            'reward_level' => User::whereHas('rewards', function ($q) use ($validated) {
                $q->where('reward_id', $validated['reward_level']);
                if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
                    $q->whereBetween('user_rewards.created_at', [
                        $validated['start_date'],
                        \Carbon\Carbon::parse($validated['end_date'])->endOfDay(),
                    ]);
                }
            })->get(),

            'individual' => User::whereIn('id', $validated['users'] ?? [])->get(),
        };

        if ($users->isEmpty()) {
            throw new \Exception('No users found for the selected criteria.');
        }

        $logDetails = [
            'send_mode' => 'custom',
            'recipient_type' => $recipientType,
            'recipients' => $users->pluck('email')->toArray(),
            'filters' => [
                'reward_level' => $validated['reward_level'] ?? null,
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
                'users' => $validated['users'] ?? null,
            ],
            'message_id' => $message->id,
            'message_subject' => $message->subject,
        ];
    }




    



    public function sendOld(Request $request, Message $message)
    {
        $validated = $request->validate([
            'recipient_type' => 'required|in:all,reward_level,individual',
            'reward_level' => 'nullable|exists:rewards,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $users = collect();

        try {
            switch ($validated['recipient_type']) {
                case 'all':
                    // Get all active users
                    $users = User::query()
                        ->where('is_admin', false)
                        ->get();
                    break;

                case 'reward_level':
                    $query = User::query()
                        ->whereHas('rewards', function ($q) use ($validated) {
                            $q->where('reward_id', $validated['reward_level']);
                            if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
                                $q->whereBetween('user_rewards.created_at', [
                                    $validated['start_date'],
                                    Carbon::parse($validated['end_date'])->endOfDay()
                                ]);
                            }
                        });
                    $users = $query->get();
                    break;

                case 'individual':
                    $users = User::whereIn('id', $validated['users'] ?? [])->get();
                    break;
            }

            if ($users->isEmpty()) {
                return back()->with('warning', 'No users found for the selected criteria.');
            }

            // Send message to users
            foreach ($users as $user) {
                // Example: you can queue or send immediately
                // $user->notify(new SendAdminMessageNotification($message));
                \Mail::to($user->email)->send(new GenericMessageMail($message, $user));
            }

            // 📝 Audit log entry
            $this->auditLogService->log(
                action: 'send_old',
                model: $message,
                data: [
                    'new' => [
                        'recipient_type' => $validated['recipient_type'],
                        'recipients' => $users->pluck('email')->toArray(),
                        'filters' => $validated,
                    ]
                ],
                description: 'Message sent using old sending method'
            );

            return back()->with('success', 'Message sent successfully to ' . $users->count() . ' users.');
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while sending the message.');
        }
    }


    public function test(Message $message, Request $request)
    {
        $email = $request->input('test_email');

        \Mail::to($email)->send(new GenericTestMessageMail($message));

        return back()->with('success', 'Messages sent!');
    }
}
