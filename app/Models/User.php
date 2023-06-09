<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{

    use Authenticatable, Authorizable, UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'users';

    protected $guarded = [];

    protected $appends = [
        'language',
        'role',
        'type'
    ];

    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

    public function getRoleAttribute()
    {
        if (!isset($this->attributes['role']))
            return null;

        return UserRole::where('sys_name', $this->attributes['role'])->first();
    }

    public function getTypeAttribute()
    {
        if (!isset($this->attributes['type']))
            return null;

        return UserType::where('sys_name', $this->attributes['type'])->first();
    }

    public function children()
    {
        return $this->hasMany(UserChildren::class, 'parent_id', 'id');
    }

    public function subscription()
    {
        return $this->hasOne(UserSubscription::class, 'user_id', 'id')
            ->where('value', 'exists', false);
    }
}
