<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'banner', 'middleware' => 'apiAuth'
],function ($router){

    // показать статьи
    Route::get('/',['uses' => 'BannerController@index']);


});