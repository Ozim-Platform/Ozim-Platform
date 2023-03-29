<?php


namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
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
//        $value = substr($value,1);

        if(!preg_match('/[+7]{2}-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/',$value))
            return false;

        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Необходимо ввести номер в формате +7-000-000-00-00';
    }

}