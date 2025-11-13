<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    protected $fillable = [
        'stats_cards',
        'sales_data',
        'category_data',
        'pie_chart_data',
        'top_products',
        'y_axis_labels',
        'year',
    ];

    protected $casts = [
        'stats_cards' => 'array',
        'sales_data' => 'array',
        'category_data' => 'array',
        'pie_chart_data' => 'array',
        'top_products' => 'array',
        'y_axis_labels' => 'array',
    ];
}
