<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class ForParent extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'for_parents';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'timestamp'
    ];

    protected $appends = [
        'category',
        'language',
    ];

    public function getCategoryAttribute()
    {
        if (!isset($this->attributes['category']))
            return null;

        return Category::where([['sys_name', $this->attributes['category']], ['type', 'for_parent']])->first();
    }


    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }
}
