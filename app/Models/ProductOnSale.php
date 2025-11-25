<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOnSale extends Model
{
     protected $fillable = [
        'woo_id', 'name', 'sku', 'price', 'image_url', 'url'
    ];
}
