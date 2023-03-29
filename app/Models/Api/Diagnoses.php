<?php

namespace App\Models\Api;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class Diagnoses extends \App\Models\Diagnoses
{

    protected $casts = [
        'created_at' => 'timestamp'
    ];

}
