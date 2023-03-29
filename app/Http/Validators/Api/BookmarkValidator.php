<?php


namespace App\Http\Validators\Api;

use App\Http\Validators\CustomValidator;
use App\Traits\ValidatorTrait;
use Illuminate\Support\Facades\Validator;

class BookmarkValidator extends CustomValidator
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

            case "store":
                return self::store($validation_fields);

            case "check":
                return self::check($validation_fields);

            case "update":
                return self::update($validation_fields);

            default:
                return self::default();

        }

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function check($validation_fields){

        return Validator::make($validation_fields, [
            'folder' => ['required','exists:article_bookmark_folders,id'],
        ], self::getMessagesValidatorFromFile('api.article.bookmark'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function store($validation_fields){

        return Validator::make($validation_fields, [
            'name' => ['required','string'],
        ], self::getMessagesValidatorFromFile('api.article.bookmark'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function update($validation_fields){

        return Validator::make($validation_fields, [
            'folder' => ['required','exists:article_bookmark_folders,id'],
            'name' => ['required','string'],
        ], self::getMessagesValidatorFromFile('api.article.bookmark'));

    }


}
