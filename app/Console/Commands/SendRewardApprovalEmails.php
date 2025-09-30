<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserReward;
use Illuminate\Support\Facades\Mail;
use App\Mail\RewardApprovedMail;

class SendRewardApprovalEmails extends Command
{
    protected $signature = 'reward:send-approval-emails {--limit=}';
    protected $description = 'Send emails when a claimed reward has been approved.';

    public function handle(): int
    {
        $limit = $this->option('limit') ?? config('services.rewards.mail_sending_limit');

        $query = UserReward::where('status', 'approved')
            ->where('email_status', '!=', 'approved');
        
        if (is_numeric($limit)) {
            $query->limit((int) $limit);
        }
        
        $rewards = $query->get();

        foreach ($rewards as $reward) {
            Mail::to($reward->user->email)->send(new RewardApprovedMail($reward));

            $reward->update([
                'email_status' => 'approved',
                'approved_at' => now(),
            ]);

            $this->info("Sent approval email to {$reward->user->email}");
        }

        return Command::SUCCESS;
    }
}