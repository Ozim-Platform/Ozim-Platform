<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumCategory as Model;

class ForumCategorySeeder    extends Seeder
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
                    'name' => 'Специальный форум',
                    'sys_name' => 'specialnyi_forum',
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
