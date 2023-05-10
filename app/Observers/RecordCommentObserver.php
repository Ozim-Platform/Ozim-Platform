<?php


namespace App\Observers;


use App\Helpers\DefaultHelper;
use App\Helpers\PushNotificationHelper;


class RecordCommentObserver
{

    public function saving($comment){

        DefaultHelper::addPoints(30);

        if($comment->comment_id === null)
        {
            // отправка пуш уведомлений пользователю
            PushNotificationHelper::sendCommentPushAnywhere($comment);
        }

        if($comment->comment_id !== null)
        {
            // отправка пуш уведомлений пользователю
            PushNotificationHelper::sendCommentOwnerPushAnywhere($comment);
        }

    }


}