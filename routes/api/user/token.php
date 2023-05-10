<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов токенов пользователей push-a
|--------------------------------------------------------------------------
|
| Содержит все маршруты токенов пользователей push-a
|
*/

Route::group(['prefix'  => 'token','middleware' => 'apiAuth', 'namespace' => 'User'],function ($router){

    // регистрация
    Route::post('/{type}/{token}','TokenController@store');

    // тест
    Route::post('/test','TokenController@test');

});