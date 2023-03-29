<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateInclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('inclusions', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // ссылка
            $collection->string('title');
            //
            $collection->string('name');
            //
            $collection->string('tags');
            // описание
            $collection->text('description');
            // язык
            $collection->string('language')->nullable();
            //
            $collection->string('image')->nullable();
            //
            $collection->string('preview')->nullable();
            // категория
            $collection->string('category')->nullable();
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
        DB::connection('mongodb')->drop(['inclusions']);
    }
}
