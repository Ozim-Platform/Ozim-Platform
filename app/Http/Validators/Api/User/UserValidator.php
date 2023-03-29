<?php


namespace App\Http\Validators\Api\User;

use App\Http\Validators\CustomValidator;
use App\Rules\AuthUserEmailUnique;
use App\Rules\AuthUserPhoneUnique;
use App\Rules\MediaFileImage;
use App\Rules\MediaFileImages;
use App\Rules\Password;
use App\Rules\Phone;
use App\Traits\ValidatorTrait;
use Illuminate\Support\Facades\Validator;

class UserValidator extends CustomValidator
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

            case "registrationUser":
                return self::registrationUser($validation_fields);

            case "authorizationUser":
                return self::authorizationUser($validation_fields);

            case "authorizationPassword":
                return self::authorizationPassword($validation_fields);

            case "updateUser":
                return self::updateUser($validation_fields);

            case "updateUserAvatar":
                return self::updateUserAvatar($validation_fields);

            case "updateUserLanguage":
                return self::updateUserLanguage($validation_fields);

            default:
                return self::default();

        }

    }

    /**
     * валидатор для регистраций пользователя
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function registrationUser($validation_fields){
        $emailRegex = '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i';

        return Validator::make($validation_fields, [
//            'phone' => ['required','unique:users',new Phone],
            'name' => ['required', 'string'],
            'email' => ['required', 'unique:users', "regex:$emailRegex", 'max:255'],
            'type' => ['required', 'exists:users_types,sys_name'],
            'language' => ['required', 'exists:languages,sys_name'],
            'password' => ['required','min:6','string', new Password],
        ], self::getMessagesValidatorFromFile('api.user.registration_user'));

    }

    /**
     * валидатор для авторизаций пользователя
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function authorizationUser($validation_fields){

        $fieldType = filter_var($validation_fields['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return Validator::make($validation_fields, [
            'username' => ['required', 'exists:users,'.$fieldType],
            'password' => ['nullable'],
            ], self::getMessagesValidatorFromFile('api.user.authorization_user'));

    }

    /**
     * валидатор для авторизаций пользователя по паролю
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function authorizationPassword($validation_fields){

        $fieldType = filter_var($validation_fields['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return Validator::make($validation_fields, [
            'username' => ['required', 'exists:users,'.$fieldType],
            'password' => ['required'],
            ], self::getMessagesValidatorFromFile('api.user.authorization_user_password'));

    }

    /**
     * валидатор для редактирование пользователя
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function updateUser($validation_fields){

        return Validator::make($validation_fields, [
            'name' =>['required','max:255'],
            'email' => ['nullable','email',new AuthUserEmailUnique()],
            'phone' => ['nullable',new Phone(),new AuthUserPhoneUnique()],
        ], self::getMessagesValidatorFromFile('api.user.update_user'));

    }

    /**
     * валидатор для загрузки аватара пользователя
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function updateUserAvatar($validation_fields){

        return Validator::make($validation_fields, [
            'avatar' => ['required',new MediaFileImage()]
            ], self::getMessagesValidatorFromFile('api.user.update_user_avatar'));

    }

    /**
     * валидатор для генерирования пароля пользователя
     * @param $validation_fields
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static function updateUserLanguage($validation_fields){

        return Validator::make($validation_fields, [
            'language' => ['required','exists:languages,sys_name'],
        ], self::getMessagesValidatorFromFile('api.user.update_user_language'));

    }

}
