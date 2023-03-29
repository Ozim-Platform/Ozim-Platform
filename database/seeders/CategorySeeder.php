<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category as Model;

class CategorySeeder    extends Seeder
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
//                1 => [
//                    'name' => 'Нарушения',
//                    'sys_name' => 'narusheniya',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
//                2 => [
//                    'name' => 'Навыки',
//                    'sys_name' => 'navyku',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
//                3 => [
//                    'name' => 'Ресурсы',
//                    'sys_name' => 'resoursy',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
//                4 => [
//                    'name' => 'Услугодатели',
//                    'sys_name' => 'uslugodateli',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
//                5 => [
//                    'name' => 'Права',
//                    'sys_name' => 'prava',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
//                6 => [
//                    'name' => 'Инклюзия',
//                    'sys_name' => 'inklyuziya',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
//                7 => [
//                    'name' => 'Статьи',
//                    'sys_name' => 'stati',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
//                8 => [
//                    'name' => 'Форум',
//                    'sys_name' => 'forum',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
//                9 => [
//                    'name' => 'Для мамы',
//                    'sys_name' => 'dlya_mamy',
//                    'language' => 'ru',
//                    'created_at' => date('Y-m-d'),
//                    'updated_at' => date('Y-m-d'),
//                ],
                1 => [
                    'name' => 'Болезни',
                    'sys_name' => 'bolezni',
                    'language' => 'ru',
                    'type' => 'article',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                2 => [
                    'name' => 'Фонды',
                    'sys_name' => 'fondy',
                    'language' => 'ru',
                    'type' => 'article',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                3 => [
                    'name' => 'Развитие',
                    'sys_name' => 'razvitie',
                    'language' => 'ru',
                    'type' => 'article',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                4 => [
                    'name' => 'Дерттер',
                    'sys_name' => 'dertter',
                    'language' => 'kz',
                    'type' => 'article',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                5 => [
                    'name' => 'Фондтар',
                    'sys_name' => 'fondtar',
                    'language' => 'kz',
                    'type' => 'article',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                6 => [
                    'name' => 'Даму',
                    'sys_name' => 'damu',
                    'language' => 'kz',
                    'type' => 'article',
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
