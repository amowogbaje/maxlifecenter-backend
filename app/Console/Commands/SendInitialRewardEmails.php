<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserReward;
use Illuminate\Support\Facades\Mail;
use App\Mail\RewardUnlockedMail;

class SendInitialRewardEmails extends Command
{
    protected $signature = 'reward:send-initial-emails {--limit=}';
    protected $description = 'Send initial reward unlocked emails (max 250 per run).';

    public function handle(): int
    {
        $limit = $this->option('limit') ?? config('services.rewards.reminder_limit');

        $query = UserReward::where('email_status', 'pending');
        
        if (is_numeric($limit)) {
            $query->limit((int) $limit);
        }
        
        $rewards = $query->get();

        foreach ($rewards as $reward) {
            Mail::to($reward->user->email)->send(new RewardUnlockedMail($reward));

            $reward->update([
                'email_status' => 'sent',
            ]);

            $this->info("Sent initial email to {$reward->user->email}");
        }

        return Command::SUCCESS;
    }
}