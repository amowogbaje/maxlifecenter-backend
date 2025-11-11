<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Admin extends Authenticatable implements AuthorizableContract
{
    use Notifiable, Authorizable;

    protected $guard = 'admin';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'password',
        'bio',
        'location',
        'birthday',
        'role_id',
    ];

    protected $hidden = ['password'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {
        return $this->role
            && $this->role->permissions->contains('name', $permission);
    }
}
