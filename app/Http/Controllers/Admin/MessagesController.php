<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\User;
use App\Mail\GenericMessageMail;
use App\Models\Reward;

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

    public function send(Message $message, Request $request)
    {
        $rewardLevel = $request->input('reward_level');

        $users = User::where('current_reward_id', $rewardLevel)->get();

        foreach ($users as $user) {
            \Mail::to($user->email)->send(new GenericMessageMail($message, $user));
        }

        return back()->with('success', 'Messages sent!');
    }

    public function test(Message $message, Request $request)
    {
        $rewardLevel = $request->input('reward_level');

        $users = User::where('is_admin', true)->get();

        foreach ($users as $user) {
            \Mail::to($user->email)->send(new GenericMessageMail($message, $user));
        }

        return back()->with('success', 'Messages sent!');
    }
}
