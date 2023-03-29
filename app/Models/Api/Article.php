<?php

namespace App\Models\Api;


class Article extends \App\Models\Article
{

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

}
