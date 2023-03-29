<?php

namespace App\Models\Api;


class Skill extends \App\Models\Skill
{

    protected $casts = [
        'created_at' => 'timestamp',
    ];

}
