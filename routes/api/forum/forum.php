<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'forum', 'middleware' => 'apiAuth'
],function ($router){

    //
    Route::get('/',['uses' => 'ForumController@index']);

    Route::get('/comments',['uses' => 'ForumController@indexCommentById']);
    //
    Route::post('/',['uses' => 'ForumController@store']);

    Route::group(['prefix'  => 'comment',
    ],function ($router) {

        //
        Route::get('/{id}',['uses' => 'ForumController@commentIndex']);

        //
        Route::get('/',['uses' => 'ForumController@userReplies']);

        // создать коммент к форуму / ответит
        Route::post('/',['uses' => 'ForumController@commentStore']);

        // удалить коммент
        Route::delete('/{id}',['uses' => 'ForumController@commentDelete']);
    });
});