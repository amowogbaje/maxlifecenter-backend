<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'woo_id', 'name', 'sku', 'price', 'image_url',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
