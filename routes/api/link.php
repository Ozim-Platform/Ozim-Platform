<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'links',
],function ($router){

    // показать ресурсы
    Route::get('/',['uses' => 'LinkController@index']);


});