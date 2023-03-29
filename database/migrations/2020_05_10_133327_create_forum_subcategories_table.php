<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateForumSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('forum_subcategories', function ( Blueprint $collection) {

            // уникальный айди
            $collection->increments('id');
            // название
            $collection->string('name');
            // системное название
            $collection->unique('sys_name');
            // язык
            $collection->string('language');
            // категория
            $collection->string('category');
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
        DB::connection('mongodb')->drop(['forum_subcategories']);
    }
}
