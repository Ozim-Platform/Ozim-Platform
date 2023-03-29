<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole as Model;

class UserRoleSeeder    extends Seeder
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
                    'name' => 'Администратор',
                    'sys_name' => 'admin',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                2 => [
                    'name' => 'Пользователь',
                    'sys_name' => 'user',
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
