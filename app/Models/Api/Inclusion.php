<?php

namespace App\Models\Api;


class Inclusion extends \App\Models\Inclusion
{

    protected $casts = [
        'created_at' => 'timestamp',
    ];

}
