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


Route::group(['prefix'  => 'children', 'middleware' => 'apiAuth',
],function ($router){

    Route::get('/','UserChildrenController@index');
    // создание
    Route::post('/','UserChildrenController@store');
    Route::post('/{child}','UserChildrenController@update');
    Route::delete('/{child}','UserChildrenController@destroy');

});
