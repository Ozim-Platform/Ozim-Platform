<?php

namespace App\Models\Api;


class ServiceProvider extends \App\Models\ServiceProvider
{

    protected $casts = [
        'created_at' => 'timestamp',
    ];

}
