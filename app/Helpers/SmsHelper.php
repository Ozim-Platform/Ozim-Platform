<?php


namespace App\Helpers;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class SmsHelper
{

    static public function send($text,$phone){

        // запрос на поиск кск через сервис компра
        $client = new Client();

        // реквест на получение данных
        $request = new Request('POST', 'http://kazinfoteh.org:9507/api');

        // отправка запроса и получение результата
        $response = $client->send($request,[
            'query' => [
                'action' => 'sendmessage',
                'username' => 'digital1http',
                'password' => 'AiRbKqFc2',
                'recipient' => PhoneHelper::clear_format($phone),
                'messagetype' => 'SMS:TEXT',
                'originator' => 'INFO_KAZ',
                'messagedata' => 'Ваш пароль : '.$text,
            ],
            'connect_timeout' => 90

        ]);

        DB::connection('mongodb')->table('log_sms')->insert(['sms_text' => $text,'phone' => $phone,'created_at' => date('Y-m-d H:i:s')]);


        return true;

    }

}