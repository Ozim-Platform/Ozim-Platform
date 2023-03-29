<?php


namespace App\Http\Validators\Api;

use App\Http\Validators\CustomValidator;
use App\Traits\ValidatorTrait;
use Illuminate\Support\Facades\Validator;

class QuestionnaireValidator extends CustomValidator
{
    use ValidatorTrait;

    /**
     * инициализация валидатора
     * @param string|null $request_type
     * @param array $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static public function init(string $request_type = null,array $validation_fields = []){

        switch ($request_type){

            case "index":
                return self::index($validation_fields);

            case "answer":
                return self::answer($validation_fields);

            default:
                return self::default();

        }

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function index($validation_fields){

        return Validator::make($validation_fields, [
            'language' => ['required','string','exists:languages,sys_name'],
            'category' => ['nullable','string','exists:categories,sys_name'],
        ], self::getMessagesValidatorFromFile('api.questionnaire.index'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function answer($validation_fields){

        return Validator::make($validation_fields, [
            'child_id' => ['required','integer','exists:user_children,id'],
            'answers' => ['required','array','min:6'],
            'answers.*' => ['required', 'array', 'min:6'],
            'answers.*.*' => ['required', ''],
        ], self::getMessagesValidatorFromFile('api.questionnaire.answer'));

    }

}
