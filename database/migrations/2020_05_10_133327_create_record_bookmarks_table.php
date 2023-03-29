<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateRecordBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('record_bookmarks', function ( Blueprint $collection) {

            // наименование
            $collection->integer('user_id');
            // название
            $collection->integer('record_id');
            // тип
            $collection->string('type');
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
        DB::connection('mongodb')->drop(['record_bookmarks']);
    }
}
