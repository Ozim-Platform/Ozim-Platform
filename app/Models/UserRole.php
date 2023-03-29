<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class UserRole extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'users_roles';

    protected $guarded = [];


}
