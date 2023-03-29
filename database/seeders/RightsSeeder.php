<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rights as Model;

class RightsSeeder    extends Seeder
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
                    'title' => 'Название',
                    'description' => 'Описание прав',
                    'category' => 'razvitie',
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
