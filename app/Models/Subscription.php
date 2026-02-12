<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['title', 'description', 'contact_ids'];

    protected $casts = [
        'contact_ids' => 'array',
    ];

    public function getUserCountAttribute()
    {
        return count($this->contact_ids ?? []);
    }
}
