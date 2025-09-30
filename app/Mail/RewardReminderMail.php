<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserReward;

class RewardReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reward;

    public function __construct(UserReward $reward)
    {
        $this->reward = $reward;
    }

    public function build()
    {
        return $this->subject('⏰ Don’t forget your reward!')
            ->view('emails.rewards.reminder', [
                'reward' => $this->reward,
                'user' => $this->reward->user,
            ]);
    }
}
