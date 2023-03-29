<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Описание маршрутов пользователей
|--------------------------------------------------------------------------
|
| Содержит все маршруты пользователей
|
*/


Route::group(['prefix'  => 'user', 'namespace' => 'User'
],function ($router){

    // регистрация
    Route::post('registration/','UserController@registration');

    // авторизация
    Route::get('authorization/', 'UserController@authorization');

    // авторизация
    Route::get('authorization_password/', 'UserController@authorizationPassword');

    // просмотр пользователя
    Route::get('/',['middleware' => 'apiAuth', 'uses' => 'UserController@show']);

    // обновление пользователя
    Route::post('/',['middleware' => 'apiAuth', 'uses' => 'UserController@update']);

    // редактирование аватара пользователя
    Route::post('/avatar',['middleware' => 'apiAuth', 'uses' => 'UserController@updateAvatar']);

    // редактирование аватара пользователя
    Route::post('/language',['middleware' => 'apiAuth', 'uses' => 'UserController@changeLanguage']);

    // редактирование аватара пользователя
    Route::post('/get_points',['middleware' => 'apiAuth', 'uses' => 'UserController@getPoints']);

    // удаление аккаунта
    Route::delete('destroy',['middleware' => 'apiAuth', 'uses' => 'UserController@destroyAccount']);

    // редактирование пользователя
    Route::patch('/',['middleware' => 'apiAuth', 'uses' => 'UserController@update']);

    // маршруты детей
    require base_path('routes/api/user/user_children.php');

    // маршруты
    require base_path('routes/api/user/user_subscription.php');
});
