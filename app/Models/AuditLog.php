<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'action',
        'model_type',
        'model_id',
        'user_id',
        'old_data',
        'new_data',
        'description',
    ];

    protected $casts = [
        'old_data'    => 'array',
        'new_data'    => 'array',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    /**
     * The user who performed the action.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * The model instance that was acted upon.
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo(null, 'model_type', 'model_id');
    }
}
