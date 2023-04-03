<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateRecordViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('record_views', function ( Blueprint $collection) {

            // наименование
            $collection->integer('user_id');
            // название
            $collection->integer('record_id');
            // название
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
        DB::connection('mongodb')->drop(['record_views']);
    }
}