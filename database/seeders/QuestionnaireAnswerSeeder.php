<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionnaireAnswer as Model;

class QuestionnaireAnswerSeeder    extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(Model::all()->count() == 0){

            // массив для добавления статьей
            $data = [
                1 => [
                    'questionnaire_id' => 1,
                    'description' => 'Детский церебральный паралич (ДЦП) – группа заболеваний головного мозга, возникающих вследствие его недоразвития или повреждения в процессе беременности или родов, и проявляющихся двигательными расстройствами, нарушениями речи и психики.',
                    'answers' => [
                        false,
                        false,
                        false,
                        false,
                        false,
                        false,
                        false,
                        false,
                    ],
                    'language' => 'ru',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ],
                2 => [
                    'questionnaire_id' => 1,
                    'description' => 'Детский церебральный паралич (ДЦП) – группа заболеваний головного мозга, возникающих вследствие его недоразвития или повреждения в процессе беременности.',
                    'answers' => [
                        false,
                        false,
                        false,
                        false,
                        true,
                        false,
                        false,
                        true,
                    ],
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
