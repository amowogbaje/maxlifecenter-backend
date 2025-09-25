<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'title',
        'required_points',
        'required_purchases',
        'reward_benefit',
        'priority',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_rewards')
                    ->withPivot(['achieved_at', 'mail_sent', 'status'])
                    ->withTimestamps();
    }

    public function activeUsers()
    {
        return $this->hasMany(User::class, 'current_reward_id');
    }
}
