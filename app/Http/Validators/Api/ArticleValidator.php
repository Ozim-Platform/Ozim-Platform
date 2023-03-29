<?php


namespace App\Http\Validators\Api;

use App\Http\Validators\CustomValidator;
use App\Traits\ValidatorTrait;
use Illuminate\Support\Facades\Validator;

class ArticleValidator extends CustomValidator
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

            case "check":
                return self::check($validation_fields);

            case "like":
                return self::like($validation_fields);

            case "comment":
                return self::comment($validation_fields);

            case "comment_delete":
                return self::comment_delete($validation_fields);

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
        ], self::getMessagesValidatorFromFile('api.article.index'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function check($validation_fields){

        return Validator::make($validation_fields, [
            'article_id' => ['required','exists:articles,id'],
        ], self::getMessagesValidatorFromFile('api.article.like'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function like($validation_fields){

        return Validator::make($validation_fields, [
            'article_id' => ['required','exists:articles,id'],
            'folder' => ['required','exists:article_bookmark_folders,id'],
        ], self::getMessagesValidatorFromFile('api.article.like'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function comment($validation_fields){

        return Validator::make($validation_fields, [
            'article_id' => ['required','exists:articles,id'],
            'comment_id' => ['nullable','exists:article_comments,id'],
        ], self::getMessagesValidatorFromFile('api.article.comment'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function comment_delete($validation_fields){

        return Validator::make($validation_fields, [
            'comment_id' => ['required','exists:article_comments,id'],
        ], self::getMessagesValidatorFromFile('api.article.comment'));

    }


}
