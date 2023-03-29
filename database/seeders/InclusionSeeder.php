<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inclusion as Model;

class InclusionSeeder    extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(Model::all()->count() == 0){

            // массив для добавления
            $data = [
                1 => [
                    'title' => 'Название',
                    'description' => 'Описание инклюзии',
                    'category' => 'razvitie',
                    'language' => 'ru',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],

            ];

            foreach($data as $i){
                // добавление
                Model::create($i);
            }

        }

    }
}
