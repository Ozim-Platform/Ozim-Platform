<?php


namespace App\Observers;


use App\Models\QuestionnaireAnswer;


class QuestionnaireObserver
{

    public function deleting($q){

        QuestionnaireAnswer::query()->where('questionnaire_id', $q->id)->delete();

    }


}