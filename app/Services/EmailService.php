<?php


namespace App\Services;


use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendCert($user, $partner, $cert){

        $data = array('user_name' => $user->name, 'partner' => $partner);

        Mail::send('emails.cert', $data, function($message) use ($user, $partner, $cert) {
            $message->to($user->email, 'Сертификат '. $partner->name)->subject
            ('Успешно обменяли баллы на '. $partner->title);
            $message->from(env('MAIL_FROM_ADDRESS'), 'Ozim Platform');
            $message->attach($cert);
        });

    }

    public function sendResults($email, $user, $child, $answer, $file){

        $data = array('user' => $user, 'child' => $child, 'answer' => $answer, 'questionnaire' => $answer->questionnaire);

        Mail::send('emails.questionnaire_answer', $data, function($message) use ($email, $user, $child, $answer, $file) {
            $message->to($email, 'Результаты '. $child->name . ' ' . $answer->age . ' месяцев')->subject
            ('Результаты вашего ребенка  '. $user->name);
            $message->from(env('MAIL_FROM_ADDRESS'), 'Ozim Platform');
            $message->attach($file);
        });

    }

}
