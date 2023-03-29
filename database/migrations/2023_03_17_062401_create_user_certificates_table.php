<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('user_certificates', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            $collection->integer('user_id');
            $collection->integer('partner_id');
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
        DB::connection('mongodb')->drop(['user_certificates']);
    }
}
