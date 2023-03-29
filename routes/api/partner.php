<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'partner', 'middleware' => 'apiAuth', 'namespace' => 'User'
],function ($router){

    // показать партнеров
    Route::get('/',['uses' => 'PartnerController@index']);

    // Поменять баллы
    Route::post('/',['uses' => 'PartnerController@change']);


});
