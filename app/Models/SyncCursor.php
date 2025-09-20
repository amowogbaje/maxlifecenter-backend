<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncCursor extends Model
{
    protected $fillable = ['last_date'];
    protected $casts = ['last_date' => 'string'];
}
