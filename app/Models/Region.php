<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Region extends Model
{
    use HasFactory, UseAutoIncrementID;


    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'region_id', 'id')->orderBy('name');
    }
}
