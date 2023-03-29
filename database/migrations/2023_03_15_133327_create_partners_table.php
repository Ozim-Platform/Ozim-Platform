<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('partners', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // ссылка
            $collection->string('title');
            $collection->integer('expires');
            //
            $collection->string('name');
            $collection->string('price');
            // описание
            $collection->text('description');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mongodb')->drop(['partners']);
    }
}
