<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
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
        if (
            strlen($value) < 6
            || preg_match('/[А-Яа-яЁёӘәІіҢңҒғҮүҰұҚқӨөҺһ]/u', $value)
            || preg_match('/\s/u', $value)
        ) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'password | Используйте латинские буквы без пробелов';
    }
}
