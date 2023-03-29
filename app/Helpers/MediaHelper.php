<?php


namespace App\Helpers;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 * класс предназаченный для работы с различной медией
 * Class MediaHelper
 * @package App\Helper
 */
class MediaHelper
{
    /**
     * загрузка файлов
     * @param $files
     * @param $base_path
     * @return array
     */
    public static function uploadFiles($files, $base_path, $crop = null)
    {

        // массив сохраненных изображений
        $saved_files = [];

        // перебор файлов
        foreach ($files as $file) {

            // если файл является обьектом класса тогда загрузи его
            if ($file instanceof UploadedFile)
                $saved_files[] = self::uploadFile($file, $base_path, $crop);

        }

        return $saved_files;

    }

    /**
     * загрузка файла
     * @param $file
     * @param string $base_path
     * @param string $crop
     * @return array
     */
    public static function uploadFile($file, $base_path = 'default', $crop = null)
    {
        // генерация имени файла
        $file_name = rand(0, 50) . '.' . $file->getClientOriginalExtension();

        // получение пути
        $path = 'storage/' . $base_path . '/' . date('Y') . '/' . date('m') . '/' . date('d') . time();

//        if ($crop === 'crop') {
            $img = Image::make($file->path());
            $img->resize(400, 400, function ($const) {
                $const->aspectRatio();
            })->save();
//        }

        // сохранения пути
        $file->move($path, $file_name);

        $saved_file = [
            "id" => DefaultHelper::generateRandomNumber(12),
            "path" => $path . '/' . $file_name,
            "extension" => $file->getClientOriginalExtension(),
            "original_name" => $file->getClientOriginalName(),
        ];

        // если расширение файла относится к видео
        if (array_search($file->getClientOriginalExtension(),
            Config::get('app.files_videos_permitted_extension'))) {

            $saved_file["type"] = "video";

            $saved_file["preview"] = self::uploadFileVideoPreview($path,
                $path . '/' . $file_name,
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));


        }

        return $saved_file;

    }

    public static function uploadFileVideoPreview($path, $video_path, $file_original_name, $frame_second = null)
    {

        // помощник для работы с ffmpeg
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => exec('which ffmpeg'),
            'ffprobe.binaries' => exec('which ffprobe')
        ]);

        // помощник для работы с ffprobe
        $ffprobe = FFProbe::create([
            'ffmpeg.binaries' => exec('which ffmpeg'),
            'ffprobe.binaries' => exec('which ffprobe')
        ]);

        // открытие видео
        $video = $ffmpeg->open(base_path() . '/public/' . $video_path);

        // продолжительность видео
        $duration = $ffprobe->format(base_path() . '/public/' . $video_path)->get('duration');

        // путь до превью
        $preview_path = substr($video_path, 0, strrpos($video_path, '/', -1)) . '/' . rand(0, 50) . '.jpg';

        // изменение разрешения видео
        $video
            ->filters()
            ->resize(new Dimension(320, 240))
            ->synchronize();

        // сохранение кадра видео в виде превью
        $frame = $video->frame(TimeCode::fromSeconds((int)round($duration) / 2));

        // сохранение превью
        $frame->save(base_path() . '/public/' . $preview_path);

        return [
            "id" => DefaultHelper::generateRandomNumber(12),
            "path" => $preview_path,
            "extension" => "jpg",
            "type" => "image",
            "original_name" => $file_original_name . '.jpg'
        ];

    }


    public static function basePath($base_path = 'images')
    {

        return 'storage/' . $base_path . '/' . date('Y') . '/' . date('m') . '/' . date('d') . time();
    }

    /**
     * сохранение файла из формата base64
     * @param string $fileBase64
     * @param $path
     * @param $fileName
     * @param $extension
     * @return array
     */
    public static function saveFileForBase64(string $fileBase64,$path,$fileName,$extension): array
    {

        $time = date('d').time();

        File::makeDirectory('storage/'.$path,0777,false,true);
        File::makeDirectory('storage/'.$path.'/'.date('Y'),0777,false,true);
        File::makeDirectory('storage/'.$path.'/'.date('Y').'/' . date('m'),0777,false,true);
        File::makeDirectory('storage/'.$path.'/'.date('Y').'/' . date('m') . '/' . $time ,0777,false,true);

        // создание файла
        $file = fopen('storage/'.$path.'/'.date('Y').'/' . date('m') . '/' . $time.'/'.$fileName.'.'.$extension, 'wb');

        // запись данных в файл
        fwrite($file,base64_decode($fileBase64));

        // закрытие файла
        fclose($file);

        return [
            "id" => DefaultHelper::generateRandomNumber(12),
            "path" => 'storage/'.$path.'/'.date('Y').'/' . date('m') . '/' . $time.'/'.$fileName.'.'.$extension,
            "extension" => "jpg",
            "type" => "file",
            "original_name" => $fileName . '.'.$extension
        ];
    }

    /**
     * удаление файла
     * @param $path
     * @return bool
     */
    public static function destroyFile($path): bool
    {
        if(!file_exists($path))
        {
            return false;
        }

        return unlink($path);
    }

}