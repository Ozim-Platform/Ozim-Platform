<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class ForumCategory extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'forum_categories';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at'
    ];

    protected $appends = [
//        'subcategories',
        'language',
    ];

//    public function getSubcategoriesAttribute()
//    {
//        return ForumSubcategory::where('category', $this->attributes['sys_name'])->get();
//    }

    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

}
