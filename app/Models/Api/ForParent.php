<?php

namespace App\Models\Api;


class ForParent extends \App\Models\ForParent
{

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

}
