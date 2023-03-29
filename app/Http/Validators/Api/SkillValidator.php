<?php


namespace App\Http\Validators\Api;

use App\Http\Validators\CustomValidator;
use App\Traits\ValidatorTrait;
use Illuminate\Support\Facades\Validator;

class SkillValidator extends CustomValidator
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

            case "index":
                return self::index($validation_fields);

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
        ], self::getMessagesValidatorFromFile('api.link.index'));

    }

}
