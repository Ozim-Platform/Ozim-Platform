<?php


namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;

class MediaFileImages implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $files
     * @return bool
     */
    public function passes($attribute, $files)
    {

        // получение разрешенных расщирений для файлов
        $files_photos_extension = Config::get('app.files_photos_extension');

        // перебор полученных файлов
        foreach ($files as $file){

            // если элемент не является экземпляром объекта или его расширение не разрешено для загрузки тогда верни ошибку
            if ($file instanceof UploadedFile !== true ||
                array_search($file->getClientOriginalExtension(),$files_photos_extension) == false)
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
        return 'Файл должен быть одним из указанных форматах : '.implode(' , ',Config::get('app.files_photos_extension'));
    }
}