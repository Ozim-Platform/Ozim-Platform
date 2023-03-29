<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class Forum extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'forums';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'timestamp'
    ];

    protected $appends = [
//        'user',
        'language',
        'category',
        'subcategory',
    ];

    public function getCategoryAttribute()
    {
        return ForumCategory::where('sys_name', $this->attributes['category'])->first();
    }

    public function getSubcategoryAttribute()
    {
        return ForumSubcategory::where('sys_name', $this->attributes['subcategory'])->first();
    }

    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

//    public function getUserAttribute()
//    {
//        if (!isset($this->attributes['user_id']))
//            return null;
//
//        return User::where('id', (int)$this->attributes['user_id'])->first();
//    }
}
