<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('user_children', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            $collection->string('name');
            $collection->date('birth_date');
            $collection->int('gender');
            // дата создания пользователя
            $collection->dateTime('created_at');
            // дата изменения пользователя
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
        DB::connection('mongodb')->drop(['user_children']);
    }
}
