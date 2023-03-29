<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('questionnaires', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // тема
            $collection->string('title');
            //
            $collection->string('name');
            // возраст
            $collection->string('age');
            // язык
            $collection->string('language')->nullable();
            // категория
            $collection->string('category')->nullable();
            //
            $collection->string('image')->nullable();
            //
            $collection->string('preview')->nullable();
            // вопросы
            $collection->string('questions')->nullable();
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
        DB::connection('mongodb')->drop(['questionnaires']);
    }
}
