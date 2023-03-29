<?php


namespace App\Helpers;

/**
 * Класс предназначенный для валидаций различных данных
 * Class ValidateHelper
 * @package App\Helper
 */
class ValidateHelper
{
    /**
     * проверка правильности введенного номера
     * @param $phone_number
     * @return bool
     */
    static public function phone($phone_number){

//        dd($phone_number);

        // проверка номера по регулярному выражению
        // шаблон номера 0-000-000-00-00
        if(!preg_match('/^[0-9]-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/',$phone_number))
//        if(!preg_match('/ [0-9] - [0-9] {3} - [0-9] {3} - [0-9] {2} - [0-9] {2} $/',$phone_number))
           return false;

        return true;

    }

}