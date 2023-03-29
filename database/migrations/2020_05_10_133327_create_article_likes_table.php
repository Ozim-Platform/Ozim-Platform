<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateArticleLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('article_likes', function ( Blueprint $collection) {

            // наименование
            $collection->integer('user_id');
            // название
            $collection->integer('article_id');
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
        DB::connection('mongodb')->drop(['article_likes']);
    }
}
