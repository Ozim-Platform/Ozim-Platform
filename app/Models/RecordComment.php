<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class RecordComment extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'record_comments';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'timestamp'
    ];

}
