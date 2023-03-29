<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class ArticleLikes extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'article_likes';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

}
