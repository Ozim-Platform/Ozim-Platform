<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class ForumSubcategory extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'forum_subcategories';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at'
    ];

    protected $appends = [
        'category',
        'language',
        'record_count',
        'last_comment',

    ];

    public function getCategoryAttribute()
    {
        if (!isset($this->attributes['category']))
            return null;

        return ForumCategory::where('sys_name', $this->attributes['category'])->first();
    }

    public function getLanguageAttribute()
    {
        return Language::where('sys_name', $this->attributes['language'])->first();
    }

    public function getRecordCountAttribute($sys_name = null)
    {
        if ($sys_name == null)
            $posts = Forum::where('subcategory', $this->sys_name)->count();

        if ($sys_name != null)
            $posts = Forum::where('subcategory', $sys_name)->count();

        return $posts;
    }

    public function getLastCommentAttribute($sys_name = null)
    {
        if ($sys_name == null)
            $posts = Forum::where('subcategory', $this->sys_name)->orderBy('id', 'DESC')->get();

        if ($sys_name != null)
            $posts = Forum::where('subcategory', $sys_name)->orderBy('id', 'DESC')->get();

        $comment = ForumComment::query()
            ->whereIn('forum_id', $posts->pluck('id'))->orderBy('id', 'DESC')->first();

        if (!$comment)
        {
            if ($posts->first())
                return $posts->first()->created_at;
            else
                return null;
        }

        return $comment->created_at;
    }


}
