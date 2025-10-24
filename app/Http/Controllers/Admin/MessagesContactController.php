<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\MessageContact;
use App\Models\User;
use App\Mail\GenericMessageMail;
use App\Mail\GenericTestMessageMail;
use App\Models\Reward;
use Carbon\Carbon;

class MessagesContactController extends Controller
{
    public function index()
    {
        $noOfContactList = Message::count();
        $noOfMessageTemplates = Message::count();
        $messageLogCount = Message::count();
        

        $metricCards = [
            ['title' => $noOfMessageTemplates, 'subtitle' => 'Total Message Templates', 'bgColor' => 'bg-green-600', 'svgIcon' => '<i class="fi fi-tr-envelopes text-white"></i>', 'routeName' => 'admin.messages.templates.index'],
            ['title' => $noOfContactList, 'subtitle' => 'Total Contact List',  'bgColor' => 'bg-green-600','svgIcon' => '<i class="fi fi-tr-address-book text-white"></i>', 'routeName' => 'admin.messages.templates.index'],
            ['title' => $messageLogCount, 'subtitle' => 'Total Messages Sent',  'bgColor' => 'bg-green-600','svgIcon' => '<i class="fi fi-tr-newsletter-subscribe text-white"></i>', 'routeName' => 'admin.messages.templates.index'],
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

        return redirect()->route('admin.messages.contacts.edit', $contactList->id)
                        ->with('success', 'Contact list created successfully! Add Users here');
    }

    public function edit(Request $request, $id)
    {
        $contactList = MessageContact::findOrFail($id);
        // $contactList = MessageContact::with('users')->findOrFail($id);

        $selectedUserIds = collect($contactList->user_ids ?? [])
            ->merge($request->input('user_ids', []))
            ->unique()
            ->values()
            ->toArray();
        $query = User::query();
        $query->where('is_admin', false);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
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

        $users = $query->paginate(10)->appends($request->except('page'));
        $rewards = Reward::all();
        // return $selectedUserIds;

        if ($request->ajax()) {
            // Return only users table partial
            return response()->json([
                'html' => view('admin.messages.contacts.partials._user_list', compact('users', 'selectedUserIds'))->render(),
                'pagination' => view('admin.messages.contacts.partials._pagination', compact('users'))->render(),
            ]);
        }
        return view('admin.messages.contacts.edit', compact('users', 'rewards', 'contactList', 'selectedUserIds'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'integer|distinct|exists:users,id',
        ]);

        $contactList = MessageContact::findOrFail($id);

        $contactList->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_ids' => array_unique($validatedData['user_ids'] ?? []),
        ]);

        return redirect()
            ->route('admin.messages.contacts.index')
            ->with('success', 'Contact list updated successfully.');
    }


    public function preview(Message $message, Request $request)
    {
        $rewardLevel = $request->input('reward_level');
        $rewardLevels = Reward::all();

        $users = User::where('current_reward_id', $rewardLevel)->get();

        return view('admin.messages.templates.preview', compact('message', 'users', 'rewardLevel', 'rewardLevels'));
    }

    public function send(Request $request, Message $message)
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
