<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;


class CreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('users_roles', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // наименование роли
            $collection->unique('name');
            // системное наименование роли
            $collection->unique('sys_name');
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
        DB::connection('mongodb')->drop(['users_roles']);
    }
}
