<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;


class TokenDevice extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'token_devices';

    protected $guarded = [];

    protected $hidden = [
        'activity',
        'created_at',
        'updated_at'
    ];

    public static function getUserTokens($id){

       return self::where('user_id',$id)->pluck('token')->toArray();

    }

    public static function getUsersTokens($ids){

       return self::whereIn('user_id',$ids)->pluck('token')->toArray();

    }

}