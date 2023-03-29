<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User as Model;

class UserSeeder    extends Seeder
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
                    'name' => 'Галым Сарсебек',
                    'phone' => '+7-702-288-08-08',
                    'email' => 'kap1c@icloud.com',
                    'role' => 'admin',
                    'language' => 'ru',
                    'avatar' => null,
                    'password' => \Illuminate\Support\Facades\Hash::make('0808'),
                    'auth_password' => \Illuminate\Support\Facades\Hash::make('0808'),
                    'auth_token' => \Illuminate\Support\Facades\Hash::make(\App\Helpers\DefaultHelper::generateRandomNumber(15)),
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
