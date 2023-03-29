<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'region_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id','id');
    }
}
