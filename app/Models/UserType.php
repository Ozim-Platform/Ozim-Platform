<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class UserType extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'users_types';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'id',
        'created_at',
        'updated_at',
    ];

}
