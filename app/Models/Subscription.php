<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscription extends Model
{
    protected $fillable = ['title', 'description'];

    

    public function getContactCountAttribute(): int
    {
        return $this->contacts()->count();
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'subscription_contacts')->withTimestamps();
    }
}
