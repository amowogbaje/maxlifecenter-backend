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
        'id', 'user_id', 'woo_id','first_name', 'last_name', 'email', 'phone', 'gender', 'bonus_point', 'password',
        'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country'
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
        if (!$next) {
            return null;
        }

        $points = $this->orders()->sum('total_points');
        $purchases = $this->orders()->sum('product_count');

        $pointsRemaining = max(0, $next->required_points - $points);
        $purchasesRemaining = max(0, $next->required_purchases - $purchases);

        $pointsProgress = $next->required_points > 0 ? min(1, $points / $next->required_points) : 1;
        $purchasesProgress = $next->required_purchases > 0 ? min(1, $purchases / $next->required_purchases) : 1;

        $progressPercent = round(($pointsProgress + $purchasesProgress) / 2 * 100, 2);

        return [
            'next_tier' => $next,
            'points_remaining' => $pointsRemaining,
            'purchases_remaining' => $purchasesRemaining,
            'progress_percent' => $progressPercent,
        ];
    }

    
    public function rewards()
    {
        return $this->belongsToMany(Reward::class, 'user_rewards')
                    ->withPivot('achieved_at')
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

    
}
