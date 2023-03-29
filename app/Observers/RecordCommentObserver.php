<?php


namespace App\Observers;


use App\Helpers\PushNotificationHelper;


class RecordCommentObserver
{

    public function saving($comment){

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