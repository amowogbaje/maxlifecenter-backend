<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    protected $fillable = [
        'topic',
        'resource',
        'resource_id',
        'delivery_id',
        'signature_hash',
        'payload',
        'status',
        'response',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
