<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class Video extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'videos';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

    protected $appends = [
        'language',
        'category',
    ];

    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

    public function getCategoryAttribute()
    {
        if (!isset($this->attributes['category']))
            return null;

        return Category::where([['sys_name', $this->attributes['category']], ['type', 'video']])->first();
    }
}
