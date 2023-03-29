<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class Language extends Model
{

    protected $primaryKey = '_id';

    protected $table = 'languages';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'id',
        'updated_at',
        'created_at',
    ];
}
