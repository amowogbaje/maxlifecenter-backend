<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'woo_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'bonus_point',
        'password',
        'company',
        'address_1',
        'address_2',
        'city',
        'state',
        'postcode',
        'country',
        'is_admin',
        'current_reward_id',
        'bio',
        'location',
        'birthday',
        'purchases',
        'total_spent',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    /**
     * Calculate how far the user is from the next tier.
     *
     * @return array|null
     *   [
     *      'next_tier' => Reward,
     *      'points_remaining' => int,
     *      'purchases_remaining' => int,
     *      'progress_percent' => float
     *   ]
     */

    public function progressToNextTier()
    {
        $next = $this->nextTier();

        $points = $this->bonus_point;
        $purchases = $this->purchases;

        if ($next) {
            $pointsRemaining = max(0, $next->required_points - $points);
            $purchasesRemaining = max(0, $next->required_purchases - $purchases);

            $pointsProgress = $next->required_points > 0
                ? round(min(1, $points / $next->required_points) * 100, 2)
                : 100;

            $purchasesProgress = $next->required_purchases > 0
                ? round(min(1, $purchases / $next->required_purchases) * 100, 2)
                : 100;
        } else {
            // Already at max tier
            $pointsRemaining = 0;
            $purchasesRemaining = 0;
            $pointsProgress = 100;
            $purchasesProgress = 100;
        }

        return [
            'next_tier' => $next,
            'points_remaining' => $pointsRemaining,
            'purchases_remaining' => $purchasesRemaining,
            'points_progress' => $pointsProgress,
            'purchases_progress' => $purchasesProgress,
        ];
    }




    public function rewards()
    {
        return $this->belongsToMany(Reward::class, 'user_rewards')
            ->withPivot(['achieved_at', 'mail_sent', 'status'])
            ->withTimestamps();
    }

    public function allRewards()
    {
        return $this->rewards()->orderByPivot('achieved_at', 'asc')->get();
    }

    // public function latestReward()
    // {
    //     return $this->rewards()->orderByPivot('achieved_at', 'desc')->first();
    // }

    public function tier()
    {
        return $this->rewards()->orderByDesc('priority')->first();
    }

    public function nextTier()
    {
        $currentTier = $this->tier();
        if (!$currentTier) {
            return Reward::orderBy('priority')->first();
        }

        return Reward::where('priority', '>', $currentTier->priority)
            ->orderBy('priority')
            ->first();
    }

    public function currentReward()
    {
        return $this->belongsTo(Reward::class, 'current_reward_id');
    }

    // Accessor: $user->approvedTier
    public function getApprovedTierAttribute()
    {
        return $this->currentReward;
    }

    public function userRewards()
    {
        return $this->hasMany(UserReward::class);
    }

    // Accessor: $user->nextTobeApprovedTier
    public function getNextTobeApprovedTierAttribute()
    {
        if (!$this->current_reward_id) {
            // If user has no reward yet, return the first reward
            return Reward::orderBy('id')->first();
        }

        $current = $this->currentReward;

        $next = Reward::where('id', '>', $current->id)
            ->orderBy('id')
            ->first();

        return $next ?: null;
    }
}
