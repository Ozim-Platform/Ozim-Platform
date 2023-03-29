<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class ArticleBookmarkFolder extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = 'id';

    protected $table = 'article_bookmark_folders';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'timestamp'
    ];

}
