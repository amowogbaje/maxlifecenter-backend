<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'woo_id', 'user_id', 'status', 'currency', 'total',
        'discount_total', 'shipping_total', 'payment_method',
        'payment_method_title', 'transaction_id',
        'date_created', 'date_modified', 'date_completed',
        'date_paid', 'meta_data', 'bonus_point', 'reward_status'
    ];

    protected $casts = [
        'meta_data' => 'array',
        'date_created' => 'datetime',
        'date_modified' => 'datetime',
        'date_completed' => 'datetime',
        'date_paid' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
