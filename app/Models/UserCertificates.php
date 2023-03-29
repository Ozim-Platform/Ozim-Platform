<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class UserCertificates extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'user_certificates';

    protected $guarded = [];



}
