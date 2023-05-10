<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model;

class ServiceProvider extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'service_providers';

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
        return Category::where([['sys_name', $this->attributes['category']], ['type', 'service_provider']])->first();
    }

    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

    public static function rating($id = null)
    {
        if ($id != null)
            $ratings = RecordRating::where([['record_id', $id], ['type', 'service_provider']])->pluck('rating');
        else
            $ratings = RecordRating::where([['record_id', $this->attributes['id']], ['type', 'service_provider']])->pluck('rating');

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
