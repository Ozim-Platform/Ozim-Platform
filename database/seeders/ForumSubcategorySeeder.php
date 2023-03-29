<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumSubcategory as Model;

class ForumSubcategorySeeder    extends Seeder
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
                    'name' => 'Информационный',
                    'sys_name' => 'informatsionnyi',
                    'language' => 'ru',
                    'category' => 'specialnyi_forum',
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
