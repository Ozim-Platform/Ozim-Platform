<?php

namespace App\Traits;

trait ValidatorTrait{

    /**
     * получение файла сообщений для валидатора
     * @param $file_path
     * @return bool|mixed
     */
    static function getMessagesValidatorFromFile($file_path){

        $file_path = str_replace('.','/',$file_path).'.php';

        if(is_file(base_path('/resources/messages/').$file_path))
            return include base_path('/resources/messages/').$file_path;

        return false;

    }

}