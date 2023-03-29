<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class ArticleComment extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'article_comments';

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
