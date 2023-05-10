<?php


namespace App\Observers;


use App\Helpers\DefaultHelper;


class ForumObserver
{

    public function created($comment){

        DefaultHelper::addPoints(30);

    }

}