<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryType as Model;

class CategoryTypeSeeder    extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(Model::all()->count() == 0){

            // массив для добавления категории
            $data = [
                1 => [
                    'name' => 'Статьи',
                    'sys_name' => 'article',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                2 => [
                    'name' => 'Диагнозы',
                    'sys_name' => 'diagnosis',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                3 => [
                    'name' => 'Для мамы',
                    'sys_name' => 'for_parent',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                4 => [
                    'name' => 'Инклюзия',
                    'sys_name' => 'inclusion',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                5 => [
                    'name' => 'Ресурсы',
                    'sys_name' => 'link',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                6 => [
                    'name' => 'Анкета',
                    'sys_name' => 'questionnaire',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                7 => [
                    'name' => 'Права',
                    'sys_name' => 'right',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                8 => [
                    'name' => 'Услуги',
                    'sys_name' => 'service_provider',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                9 => [
                    'name' => 'Навыки',
                    'sys_name' => 'skill',
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
