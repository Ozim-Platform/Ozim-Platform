<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('categories', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // наименование
            $collection->string('name');
            // системное название
            $collection->string('sys_name');
            // язык
            $collection->string('language');
            // тип
            $collection->string('type');
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
        DB::connection('mongodb')->drop(['categories']);
    }
}
