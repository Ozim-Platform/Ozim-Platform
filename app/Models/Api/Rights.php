<?php

namespace App\Models\Api;


class Rights extends \App\Models\Rights
{

    protected $casts = [
        'created_at' => 'timestamp',
    ];

}
