<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageContact extends Model
{
    protected $fillable = ['title', 'description', 'user_ids'];

    protected $casts = [
        'user_ids' => 'array',
    ];

    public function getUserCountAttribute()
    {
        return count($this->user_ids ?? []);
    }
}
