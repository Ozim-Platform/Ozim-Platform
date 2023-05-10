<?php


namespace App\Observers;


use App\Helpers\DefaultHelper;


class RecordRatingObserver
{

    public function saving(){

        DefaultHelper::addPoints(20);
    }


}