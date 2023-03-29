<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Forum as Model;

class ForumSeeder    extends Seeder
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
                    'title' => 'Каково глобальное бремя болезни, ассоциированное с ВГВ?',
                    'description' => 'По оценкам ВОЗ, в настоящее время в мире насчитывается 257 млн человек, живущих с хронической инфекцией гепатита В и, следовательно, подверженных риску серьезного заболевания и смерти от цирроза и рака печени. Каждый год от хронического вирусного гепатита В, по оценкам ВОЗ, умирает почти 900 000 человек, главным образом в результате вызванных гепатитом осложнений, таких как цирроз и рак печени. Страны с наибольшей распространенностью гепатита В расположены в Регионе Западной части Тихого океана и Африканском регионе ВОЗ, а с наименьшей – в Регионе стран Америки и Европейском регионе.',
                    'language' => 'ru',
                    'category' => 'specialnyi_forum',
                    'subcategory' => 'informatsionnyi',
                    'user_id' => User::first()->{'id'},
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
