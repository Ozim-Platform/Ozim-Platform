<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class Inclusion extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'inclusions';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'timestamp'
    ];

    protected $appends = [
        'category',
        'language'
    ];

    public function getCategoryAttribute()
    {
        return Category::where([['sys_name', $this->attributes['category']], ['type', 'inclusion']])->first();
    }

    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

}
