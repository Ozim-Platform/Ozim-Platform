<?php


namespace App\Rules;


use App\Models\User\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Validation\Rule;

class AuthUserPhoneUnique implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // инициализация репозитория
        $userRepository = new UserRepository();

       return $userRepository->userFieldUniqueCheck('phone',$value,$userRepository->getAuthUser()->_id);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Номер телефона должен быть уникальным';
    }
}