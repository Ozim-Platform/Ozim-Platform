<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'forum_category',
],function ($router){

    //
    Route::get('/',['uses' => 'ForumCategoryController@index']);


});