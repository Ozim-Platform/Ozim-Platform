<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Category extends Model
{

    protected $primaryKey = '_id';

    protected $table = 'categories';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'id',
        'updated_at',
        'created_at',
    ];

    protected $appends = [
        'language',
        'type'
    ];

    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

    public function getTypeAttribute()
    {
        if (!isset($this->attributes['type']))
            return null;

        return CategoryType::where('sys_name', $this->attributes['type'])->first();
    }
}
