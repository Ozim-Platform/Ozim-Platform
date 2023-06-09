<?php


namespace App\Observers;


use App\Models\ArticleComment;
use App\Models\RecordComment;


class UserObserver
{

    public function deleted($user){
        RecordComment::query()->where('user_id', $user->id)->delete();
        ArticleComment::query()->where('user_id', $user->id)->delete();
    }

}