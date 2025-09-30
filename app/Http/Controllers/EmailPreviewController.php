<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserReward;
use Illuminate\Http\Request;

class EmailPreviewController extends Controller
{
    public function password()
    {
        $user = User::first();
        $resetUrl = "https://google.com?q=male";
        return view('emails.password_reset', compact('user', 'resetUrl'));
    }

    public function index()
    {
        $templates = [
            [
                'title' => 'Reward Unlocked',
                'description' => 'Email sent when user unlocks a new reward.',
                'route' => route('emails.unlocked'),
                'bg' => 'bg-gradient-to-r from-blue-500 to-indigo-500',
            ],
            [
                'title' => 'Reward Reminder',
                'description' => 'Bi-weekly reminder for unclaimed rewards.',
                'route' => route('emails.reminder'),
                'bg' => 'bg-gradient-to-r from-yellow-400 to-orange-500',
            ],
            [
                'title' => 'Reward Approved',
                'description' => 'Email sent when a claimed reward is approved.',
                'route' => route('emails.approved'),
                'bg' => 'bg-gradient-to-r from-green-500 to-emerald-600',
            ],
            [
                'title' => 'Password',
                'description' => 'Email sent for password reset.',
                'route' => route('emails.password'),
                'bg' => 'bg-gradient-to-r from-red-500 to-orange-500',
            ],
            // Add more templates easily here...
        ];

        return view('emails.index', compact('templates'));
    }

    public function unlocked()
    {
        $reward = UserReward::first();
        return view('emails.rewards.unlocked', [
            'reward' => $reward,
            'user' => $reward->user,
        ]);
    }

    public function reminder()
    {
        $reward = UserReward::first();
        return view('emails.rewards.reminder', [
            'reward' => $reward,
            'user' => $reward->user,
        ]);
    }

    public function approved()
    {
        $reward = UserReward::first();
        return view('emails.rewards.approved', [
            'reward' => $reward,
            'user' => $reward->user,
        ]);
    }

}
