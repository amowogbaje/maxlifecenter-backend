<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    protected $fillable = [
        'last_date', 'order_ids', 'status',
    ];

    protected $casts = [
        'order_ids' => 'array',
        'last_date' => 'datetime',
    ];
}
