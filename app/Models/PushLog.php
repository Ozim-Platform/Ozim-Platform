<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class PushLog extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'push_logs';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

}
