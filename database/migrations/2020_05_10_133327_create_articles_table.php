<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('articles', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // наименование
            $collection->string('name');
            // название
            $collection->string('title');
            // описание
            $collection->string('description');
            // для поиска
            $collection->string('tags');
            // автор
            $collection->string('author');
            // должеость автора
            $collection->string('author_position');
            // фото автора
            $collection->string('author_photo');
            // язык
            $collection->string('language')->nullable();
            // фото
            $collection->string('image')->nullable();
            // обложка
            $collection->string('preview')->nullable();
            // дата создания языка
            $collection->dateTime('created_at');
            // дата изменения языка
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
        DB::connection('mongodb')->drop(['articles']);
    }
}
