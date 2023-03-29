<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateCategoryTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('category_type', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // наименование
            $collection->string('name');
            // системное название
            $collection->string('sys_name');
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
        DB::connection('mongodb')->drop(['category_type']);
    }
}
