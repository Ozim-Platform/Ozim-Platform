<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'service_provider',
],function ($router){

    // показать  услугодателей
    Route::get('/',['uses' => 'ServiceProviderController@index']);

});