<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('faqs', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // название
            $collection->string('title');
            // описание
            $collection->string('description');
            // язык
            $collection->string('language');
            //
            $collection->string('image');
            //
            $collection->string('preview');
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
        DB::connection('mongodb')->drop(['faqs']);
    }
}
