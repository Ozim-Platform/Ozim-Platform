<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Partner extends Model
{
    use HasFactory, UseAutoIncrementID;

    protected $guarded = [];

    protected $hidden = [
        '_id',
    ];

    protected $casts = [
        'price' => 'int',
    ];

    public $timestamps = false;

}
