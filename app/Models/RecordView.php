<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class RecordView extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'record_views';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

}
