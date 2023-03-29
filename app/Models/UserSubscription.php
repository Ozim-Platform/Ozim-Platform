<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;

class UserSubscription extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'user_subscriptions';

    protected $guarded = [];

     protected $hidden = [
         '_id'
     ];

    protected $casts = [
        'value' => 'array',
        'updated_at' => 'timestamp',
        'created_at' => 'timestamp',
    ];

}
