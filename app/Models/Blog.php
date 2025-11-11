<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
