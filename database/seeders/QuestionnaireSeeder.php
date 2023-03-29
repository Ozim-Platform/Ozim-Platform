<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Questionnaire as Model;

class QuestionnaireSeeder    extends Seeder
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
                    'title' => 'Эмоционально-волевое поведение',
                    'age' => '1-3',
                    'category' => 'razvitie',
                    'questions' => [
                        'Если вы указываете пальцем на что-то в другом конце комнаты, ваш ребенок на это смотрит?',
                        'Ваш ребенок делает необычные движения пальцами перед глазами?',
                        'Ребенок интересуется другими детьми?',
                        'Когда вы улыбаетесь ребенку, он или она улыбается в ответ?',
                        'Откликается ли ребенок на свое имя?',
                        'Ребенка расстраивают обычные звуки?',
                        'Ребенок смотрит вам в глаза, когда вы говорите с ним, играете или одеваете?',
                        'Ребенок пытается копировать то, что вы делаете?'
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
