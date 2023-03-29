<?php


namespace App\Http\Validators\Api;

use App\Http\Validators\CustomValidator;
use App\Traits\ValidatorTrait;
use Illuminate\Support\Facades\Validator;

class ForumValidator extends CustomValidator
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

            case "store":
                return self::store($validation_fields);

            case "comment":
                return self::comment($validation_fields);

            case "commentIndex":
                return self::commentIndex($validation_fields);

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
            'language' => ['required','string','exists:languages,sys_name'],
            'category' => ['nullable','string','exists:forum_categories,sys_name'],
            'subcategory' => ['nullable','string','exists:forum_subcategories,sys_name'],
        ], self::getMessagesValidatorFromFile('api.forum.index'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function store($validation_fields){

        return Validator::make($validation_fields, [
            'language' => ['required','string','exists:languages,sys_name'],
            'category' => ['nullable','string','exists:forum_categories,sys_name'],
            'subcategory' => ['nullable','string','exists:forum_subcategories,sys_name'],
            'title' => ['required','string'],
            'description' => ['required','string'],
        ], self::getMessagesValidatorFromFile('api.forum.store'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function comment($validation_fields){

        return Validator::make($validation_fields, [
            'forum_id' => ['required','exists:forums,id'],
            'comment_id' => ['nullable','exists:forum_comments,id'],
        ], self::getMessagesValidatorFromFile('api.forum.comment'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function commentIndex($validation_fields){

        return Validator::make($validation_fields, [
            'comment_id' => ['required', 'integer'],
        ], self::getMessagesValidatorFromFile('api.forum.comment'));

    }

    /**
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function comment_delete($validation_fields){

        return Validator::make($validation_fields, [
            'comment_id' => ['required','exists:forum_comments,id'],
        ], self::getMessagesValidatorFromFile('api.forum.comment'));

    }


}
