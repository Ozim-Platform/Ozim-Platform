<?php


namespace App\Helpers;

use App\Models\{Faq,
    Forum,
    Link,
    PushLog,
    Questionnaire,
    Diagnoses,
    ForParent,
    Inclusion,
    RecordComment,
    Rights,
    ServiceProvider,
    Skill,
    Article,
    ArticleComment,
    ForumComment,
    TokenDevice};
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class PushNotificationHelper
{
    //  отправка пуш уведомлений firebase
   static public function sendPush(array $data,array $registration_ids = [],string $type = 'android', $user = null){

       sort($registration_ids);

        // запрос на поиск кск через сервис компра
        $client = new Client();

        // реквест на получение данных
        $request = new Request('POST', 'https://fcm.googleapis.com/fcm/send',[
            'Authorization' => 'key='.env('FIREBASE_API_KEY'),
            'Accept'     => 'application/json',
            'Content-type' => 'application/json',
        ]);

        $al_res = [];

        foreach ($registration_ids as $k => $i){

            // отправка запроса и получение результата
            $response = $client->send($request,[
                'body' => json_encode(['notification' => $data, 'to' => $i, 'data' => $data['data']]),
                'notification' => json_encode($data),
                'connect_timeout' => 90,
                'data' => json_encode($data['data']),
            ]);

            // получение ответа
            $result = json_decode($response->getBody()->getContents())->results;

            // обработка ответа
            foreach ($result as $k => $i) {

                // если есть ошибка незарегестрированный токен
                // удали из бд этот токен
                if(isset($i->error) && $i->error === 'InvalidRegistration')
                    TokenDevice::where('token',$registration_ids[$k])->delete();

            }

            $log = new PushLog();
            $log->data = $data;
            $log->result = $result;
            $log->user = $user;
            $log->from = Auth::user()->id ?? null;

            $log->save();

            $al_res = array_merge($al_res,$result);

        }

       return true;

    }

    /**
     * отправка пуш уведомления на созданный комментарий в статьях
     * @param $comment
     */
   public static function sendCommentPush($comment): void
   {
        // получение записи с новостной ленты
        $news_feed = Article::where('id',$comment->article_id)->first();

        // токены пользователя
        $tokens_user = $comment->user_id !== $news_feed->user_id ? TokenDevice::getUserTokens($news_feed->user_id) : [];

        // обьединение всех токенов
        $tokens = $tokens_user;

        self::sendPush([
            'body' => 'Новый комментарий к заявке '.$news_feed->name,
            'title' => 'Уведомление',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => $news_feed->toArray()
        ],$tokens, '', $news_feed->user_id);

   }

    /**
     * отправка пуш уведомления на созданный комментарий в статьях
     * @param $comment
     */
   public static function sendCommentPushAnywhere($comment): void
   {
        // получение записи с новостной ленты
        switch ($comment->type)
        {
            case 'diagnosis':
                $news_feed = Diagnoses::query()->where('id', (int)$comment->record_id)->first();

                break;

            case 'faq':
                $news_feed = Faq::query()->where('id', (int)$comment->record_id)->first();
                break;

            case 'for_parent':
                $news_feed = ForParent::query()->where('id', (int)$comment->record_id)->first();

                break;

            case 'forum':
                $news_feed = Forum::query()->where('id', (int)$comment->record_id)->first();

                break;

            case 'inclusion':
                $news_feed = Inclusion::query()->where('id', (int)$comment->record_id)->first();

                break;

            case 'link':
                $news_feed = Link::query()->where('id', (int)$comment->record_id)->first();

                break;

            case 'questionnaire':
                $news_feed = Questionnaire::query()->where('id', (int)$comment->record_id)->first();

                break;

            case 'right':
                $news_feed = Rights::query()->where('id', (int)$comment->record_id)->first();

                break;

            case 'service_provider':
                $news_feed = ServiceProvider::query()->where('id', (int)$comment->record_id)->first();

                break;

            case 'skill':
                $news_feed = Skill::query()->where('id', (int)$comment->record_id)->first();

                break;
        }

        // токены пользователя
        $tokens_user = $comment->user_id !== $news_feed->user_id ? TokenDevice::getUserTokens($news_feed->user_id) : [];

        // обьединение всех токенов
        $tokens = $tokens_user;

        self::sendPush([
            'body' => 'Новый комментарий к посту '.$news_feed->name,
            'title' => 'Уведомление',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => $news_feed->toArray()
        ],$tokens, '', $news_feed->user_id);

   }

    /**
     * отправка пуш уведомления на созданный комментарий в форуме
     * @param $comment
     */
   public static function sendForumCommentPush($comment): void
   {
        // получение записи с новостной ленты
        $news_feed = Forum::where('id',$comment->forum_id)->first();

        // токены пользователя
        $tokens_user = $comment->user_id !== $news_feed->user_id ? TokenDevice::getUserTokens($news_feed->user_id) : [];

        // обьединение всех токенов
        $tokens = $tokens_user;

        self::sendPush([
            'body' => 'Новый комментарий в форуме '.$news_feed->title,
            'title' => 'Уведомление',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => $news_feed->toArray()
        ],$tokens, '', $news_feed->user_id);

   }

    /**
     * отправка пуш уведомления на созданный комментарий в статьях
     * @param $comment
     */
   public static function sendCommentOwnerPush($comment): void
   {
        // получение записи с новостной ленты
        $ownersComment = ArticleComment::where('id',$comment->comment_id)->first();

        // токены пользователя
        $tokens_user = TokenDevice::getUserTokens($ownersComment->user_id);

        // обьединение всех токенов
        $tokens = $tokens_user;

        self::sendPush([
            'body' => 'Новый комментарий к вашему комментарию',
            'title' => 'Уведомление',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => $ownersComment->toArray()
        ],$tokens, '', $ownersComment->user_id);

   }

    /**
     * отправка пуш уведомления на созданный комментарий в статьях
     * @param $comment
     */
   public static function sendCommentOwnerPushAnywhere($comment): void
   {
        // получение записи с новостной ленты
        $ownersComment = RecordComment::where('id',$comment->comment_id)->first();

        // токены пользователя
        $tokens_user = TokenDevice::getUserTokens($ownersComment->user_id);

        // обьединение всех токенов
        $tokens = $tokens_user;

        self::sendPush([
            'body' => 'Новый комментарий к вашему комментарию',
            'title' => 'Уведомление',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => $ownersComment->toArray()
        ],$tokens, '', $ownersComment->user_id);

   }

    /**
     * отправка пуш уведомления на созданный комментарий в форуме
     * @param $comment
     */
   public static function sendForumCommentOwnerPush($comment): void
   {
        // получение записи с новостной ленты
        $ownersComment = ForumComment::where('id',$comment->comment_id)->first();

        // токены пользователя
        $tokens_user = TokenDevice::getUserTokens($ownersComment->user_id);

        // обьединение всех токенов
        $tokens = $tokens_user;

        self::sendPush([
            'body' => 'Новый комментарий к вашему комментарию в форуме',
            'title' => 'Уведомление',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => $ownersComment->toArray()
        ],$tokens, '', $ownersComment->user_id);

   }

    /**
     * отправка пуш уведомления в чате
     * @param $user
     */
    public static function sendChatPush($user): void
    {

        // токены пользователя
        $tokens_user = TokenDevice::getUserTokens($user->id);

        self::sendPush([
            'body' => 'Вам написал '.Auth::user()->name,
            'title' => 'Уведомление',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => ['data'=> 'Сообщение в чате']
        ],$tokens_user, '', $user->_id);

    }

    /**
     * отправка пуш уведомления родителю
     * @param $user
     */
    public static function sendPushForChildParent($user, $child): void
    {

        // токены пользователей
        $tokens_user = TokenDevice::getUserTokens($user);

        self::sendPush([
            'body' => 'Доступен новый опросник для ' . $child->name,
            'title' => 'Уведомление',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => ['child_id' => $child->id]
        ],$tokens_user, '');

    }
}