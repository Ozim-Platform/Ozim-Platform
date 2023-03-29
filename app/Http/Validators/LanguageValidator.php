<?php


namespace App\Http\Validators;

use App\Traits\ValidatorTrait;
use Illuminate\Support\Facades\Validator;

class LanguageValidator extends CustomValidator
{
    use ValidatorTrait;

    /**
     * инициализация валидатора
     * @param string|null $request_type
     * @param array $validation_fields
     * @return bool|string
     */
    static public function init(string $request_type = null,array $validation_fields = []){

        switch ($request_type){

            case "change":
                return self::change($validation_fields);

            case "check":
                return self::check($validation_fields);

            default:
                return self::default();

        }

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function change($validation_fields){

        return Validator::make($validation_fields, [
            'language' => ['required','string','exists:languages,sys_name'],
        ], self::getMessagesValidatorFromFile('api.language.change'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function check($validation_fields){

        return Validator::make($validation_fields, [
            'language' => ['required','string','exists:languages,sys_name'],
        ], self::getMessagesValidatorFromFile('api.language.check'));

    }


}
