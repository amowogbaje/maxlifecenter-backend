<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserReward;
use Illuminate\Support\Facades\Mail;
use App\Mail\RewardReminderMail;
use Carbon\Carbon;

class SendRewardReminders extends Command
{
    protected $signature = 'reward:send-reminders {--limit=}';
    protected $description = 'Send bi-weekly reminder emails for unclaimed rewards.';

    public function handle(): int
    {
        $limit = $this->option('limit') ?? config('services.rewards.mail_sending_limit');
        $twoWeeksAgo = Carbon::now()->subWeeks(2);

        $query = UserReward::where('email_status', 'sent')
            ->whereNull('claimed_at')
            ->where(function ($query) use ($twoWeeksAgo) {
                $query->whereNull('last_reminder_sent_at')
                      ->orWhere('last_reminder_sent_at', '<=', $twoWeeksAgo);
            });

            if (is_numeric($limit)) {
                $query->limit((int) $limit);
            }

            $rewards = $query->get();

        foreach ($rewards as $reward) {
            Mail::to($reward->user->email)->send(new RewardReminderMail($reward));

            $reward->update([
                'email_status' => 'reminded',
                'last_reminder_sent_at' => now(),
            ]);

            $this->info("Sent reminder email to {$reward->user->email}");
        }

        return Command::SUCCESS;
    }
}
