<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserReward;

class RewardUnlockedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reward;

    public function __construct(UserReward $reward)
    {
        $this->reward = $reward;
    }

    public function build()
    {
        return $this->subject('🎉 You’ve unlocked a reward!')
            ->view('emails.rewards.unlocked', [
                'reward' => $this->reward,
                'user' => $this->reward->user,
            ]);
    }
}
