<?php


namespace App\Observers;


use App\Helpers\DefaultHelper;


class RecordLikeObserver
{

    public function saving(){

        DefaultHelper::addPoints(10);
    }

}