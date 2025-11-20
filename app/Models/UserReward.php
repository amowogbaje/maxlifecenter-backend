<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    protected $fillable = [
        'user_id',
        'reward_id',
        'status',
        'mail_sent',
        'achieved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function scopeHighestClaimed($query)
    {
        return $query->where('status', 'claimed')
            ->orderBy('reward_id', 'desc'); // or priority if you have one
    }
}
