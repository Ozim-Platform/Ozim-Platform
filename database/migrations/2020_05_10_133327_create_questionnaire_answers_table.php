<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateQuestionnaireAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('questionnaire_answers', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // ID
            $collection->integer('questionnaire_id');
            // описание
            $collection->text('description');
            // язык
            $collection->string('language');
            // вопросы
            $collection->string('answers');
            //
            $collection->string('image')->nullable();
            // дата создания
            $collection->dateTime('created_at');
            // дата изменения
            $collection->dateTime('updated_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mongodb')->drop(['questionnaire_answers']);
    }
}
