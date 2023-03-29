<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Описание маршрутов пользователей
|--------------------------------------------------------------------------
|
| Содержит все маршруты пользователей
|
*/


Route::group(['prefix'  => 'subscription', 'middleware' => 'apiAuth',
],function ($router){

    Route::get('/',['middleware' => 'apiAuth', 'uses' => 'UserSubscriptionController@index']);

    Route::post('/',['middleware' => 'apiAuth', 'uses' => 'UserSubscriptionController@subscription']);

});
