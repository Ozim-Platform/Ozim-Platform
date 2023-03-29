<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class CategoryType extends Model
{

    protected $primaryKey = '_id';

    protected $table = 'category_type';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'id',
        'updated_at',
        'created_at',
    ];
}
