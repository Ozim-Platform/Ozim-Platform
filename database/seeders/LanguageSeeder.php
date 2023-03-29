<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language as Model;

class LanguageSeeder    extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(Model::all()->count() == 0){

            // массив для добавления пользователей
            $data = [
                1 => [
                    'id' => 1,
                    'name' => 'Қазақ тілі',
                    'sys_name' => 'kz',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                2 => [
                    'id' => 2,
                    'name' => 'Русский язык',
                    'sys_name' => 'ru',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],

            ];

            foreach($data as $i){
                // добавление пользователей
                Model::create($i);
            }

        }

    }
}
