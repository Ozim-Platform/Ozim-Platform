<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType as Model;

class UserTypeSeeder    extends Seeder
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
                    'name' => 'Родитель',
                    'sys_name' => 'parent',
                    'language' => 'ru',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                2 => [
                    'id' => 2,
                    'name' => 'Специалист',
                    'sys_name' => 'specialist',
                    'language' => 'ru',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                3 => [
                    'id' => 3,
                    'name' => 'Организация',
                    'sys_name' => 'organization',
                    'language' => 'ru',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                4 => [
                    'id' => 4,
                    'name' => 'Ата-ана',
                    'sys_name' => 'ata-ana',
                    'language' => 'kz',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                5 => [
                    'id' => 5,
                    'name' => 'Маман',
                    'sys_name' => 'maman',
                    'language' => 'kz',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                6 => [
                    'id' => 6,
                    'name' => 'Мекеме',
                    'sys_name' => 'mekeme',
                    'language' => 'kz',
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
