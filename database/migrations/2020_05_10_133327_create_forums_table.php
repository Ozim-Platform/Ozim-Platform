<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('forums', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // название
            $collection->string('title');
            //
            $collection->string('name');
            //
            $collection->string('tags');
            // описание
            $collection->text('description');
            // язык
            $collection->string('language');
            // категория
            $collection->string('category');
            //
            $collection->string('image')->nullable();
            //
            $collection->string('preview')->nullable();
            // пользователь
            $collection->string('user_id');
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
        DB::connection('mongodb')->drop(['forums']);
    }
}
