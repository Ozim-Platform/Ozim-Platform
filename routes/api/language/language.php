<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'language',
],function ($router){

    // добавление токена
    Route::get('/',['uses' => 'LanguageController@index']);


});