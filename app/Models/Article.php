<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class Article extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'articles';

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

        return Category::where([['sys_name', $this->attributes['category']], ['type', 'article']])->first();
    }


    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

    public static function rating($id)
    {
        $ratings = RecordRating::where([['record_id', $id], ['type', 'article']])->pluck('rating');

        $value = 0;

        foreach ($ratings as $rating) {
            $value += $rating;
        }

        if (sizeof($ratings) == 0)
            $size = 1;
        else
            $size = sizeof($ratings);

        return $value/$size;
    }
}
