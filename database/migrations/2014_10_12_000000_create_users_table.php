<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;


class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('users', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // имя указанное пользователем
            $collection->string('nickname');
            // имя пользователя
            $collection->string('name');
            // почта пользователя
            $collection->string('email');
            // телефон пользователя
            $collection->string('phone');
            // роль пользователя
            $collection->string('role');
            // аватар пользователя
            $collection->string('avatar');
            // язык
            $collection->string('language');
            // тип
            $collection->string('type');
            // пароль при авторизации
            $collection->string('auth_password');
            // токен выдаваемый при авторизации
            $collection->string('auth_token');
            // пароль пользователя
            $collection->string('password');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mongodb')->drop(['users']);
    }
}
