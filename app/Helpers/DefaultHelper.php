<?php


namespace App\Helpers;

/**
 * Класс предназначенный для вспомогательных функций
 * Class DefaultHelper
 * @package App\Helper
 */
class DefaultHelper
{
    /**
     * генерация рандомной строки
     * @param int $length
     * @return string
     */
   static function generateRandomNumber($length = 40) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // конвер байтов в удобный формат
    static function convertByte($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');

        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    /**
     * получение файла сообщений для валидатора
     * @param $file_path
     * @return bool|mixed
     */
    static function getMessagesValidatorFromFile($file_path){

       if(is_file(base_path('/resources/messages/').$file_path))
           return include base_path('/resources/messages/').$file_path;

       return false;

    }

   static function mb_ucfirst($string)
    {
        $firstChar = mb_substr($string, 0, 1);
        $then = mb_substr($string, 1, null);
        return mb_strtoupper($firstChar) . $then;
    }

}