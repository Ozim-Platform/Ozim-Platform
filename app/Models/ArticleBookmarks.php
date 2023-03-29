<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class ArticleBookmarks extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'article_bookmarks';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

    protected $appends = [
        'article',
        'folder',
    ];

    public function getArticleAttribute()
    {
        return Article::where('id', $this->attributes['article_id'])->first();
    }

    public function getFolderAttribute()
    {
        return ArticleBookmarkFolder::where('id', $this->attributes['folder'])->first();
    }

}
