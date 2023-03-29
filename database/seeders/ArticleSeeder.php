<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article as Model;

class ArticleSeeder    extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(Model::all()->count() == 0){

            // массив для добавления статьей
            $data = [
                1 => [
                    'name' => 'Болезни',
                    'title' => 'bolezni',
                    'description' => 'bolezni',
                    'author' => 'Алибек жумаханов',
                    'author_position' => 'Врач-реабилитолог',
                    'author_photo' => null,
                    'category' => 'razvitie',
                    'image' => null,
                    'language' => 'ru',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],


            ];

            foreach($data as $i){
                // добавление категории
                Model::create($i);
            }

        }

    }
}
