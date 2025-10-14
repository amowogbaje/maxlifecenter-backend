<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\User;
use App\Mail\GenericMessageMail;
use App\Mail\GenericTestMessageMail;
use App\Models\Reward;
use Carbon\Carbon;

class MessagesController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('admin.messages.index', compact('messages'));
    }

    public function create()
    {
        return view('admin.messages.create');
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

        return redirect()->route('admin.messages.index')
                        ->with('success', 'Message template created successfully.');
    }


    public function preview(Message $message, Request $request)
    {
        $rewardLevel = $request->input('reward_level');
        $rewardLevels = Reward::all();

        $users = User::where('current_reward_id', $rewardLevel)->get();

        return view('admin.messages.preview', compact('message', 'users', 'rewardLevel', 'rewardLevels'));
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
