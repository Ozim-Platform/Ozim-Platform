<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('service_providers', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // ссылка
            $collection->string('title');
            //
            $collection->string('name');
            // описание
            $collection->text('description');
            //
            $collection->text('phone');
            //
            $collection->text('email');
            //
            $collection->text('link');
            // язык
            $collection->string('language')->nullable();
            // для поиска
            $collection->string('tags');
            // для поиска
            $collection->integer('rating');
            // категория
            $collection->string('category')->nullable();
            //
            $collection->string('image')->nullable();
            //
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
        DB::connection('mongodb')->drop(['service_providers']);
    }
}
