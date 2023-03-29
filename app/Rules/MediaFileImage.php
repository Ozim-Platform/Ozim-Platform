<?php


namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;

class MediaFileImage implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $file
     * @return bool
     */
    public function passes($attribute, $file)
    {
        // если элемент не является экземпляром объекта или его расширение не разрешено для загрузки тогда верни ошибку
        if ($file instanceof UploadedFile !== true ||
            array_search($file->getClientOriginalExtension(),Config::get('app.files_photos_extension')) == false)
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
        return 'Файл должен быть одним из указанных форматах : '.implode(' , ',Config::get('app.files_photos_extension'));
    }
}