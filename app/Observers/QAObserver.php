<?php


namespace App\Observers;


use App\Helpers\DefaultHelper;


class QAObserver
{

    public function saving($comment){

        DefaultHelper::addPoints(50);

    }


}