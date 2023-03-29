<?php


namespace App\Observers;


use App\Helpers\PushNotificationHelper;


class ForumCommentObserver
{

    public function saving($comment){

        if($comment->comment_id === null)
        {
            // отправка пуш уведомлений пользователю
            PushNotificationHelper::sendForumCommentPush($comment);
        }

        if($comment->comment_id !== null)
        {
            // отправка пуш уведомлений пользователю
            PushNotificationHelper::sendForumCommentOwnerPush($comment);
        }

    }


}