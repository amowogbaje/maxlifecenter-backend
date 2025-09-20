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

    // Tier mapping (points => tier)
    protected static array $tiers = [
        0   => 'Eleniyan',
        20  => 'Oloye',
        30  => 'Kabiyesi',
        40  => 'Balogun',
        50  => 'Oba',
        60  => 'Aare',
        70  => 'Olori',
        // Add more tiers as needed
    ];

    // Computed full name
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }



    // Computed tier
    public function getTierAttribute(): string
    {
        $tier = 'Eleniyan'; // default
        foreach (self::$tiers as $points => $name) {
            if ($this->bonus_point >= $points) {
                $tier = $name;
            } else {
                break;
            }
        }
        return $tier;
    }

    public function getNextTierAttribute(): ?string
    {
        $current = $this->tier; // uses accessor above
        $tiers   = array_values(self::$tiers); // reindex: 0,1,2,...
        $index   = array_search($current, $tiers, true);

        if ($index !== false && isset($tiers[$index + 1])) {
            return $tiers[$index + 1]; // the next tier name
        }

        return null; // already at last tier
    }

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
}
