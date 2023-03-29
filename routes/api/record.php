<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'record', 'middleware' => 'apiAuth'
],function ($router){

    // view
    Route::post('/view',['uses' => 'RecordController@view']);

    // like
    Route::post('/like',['uses' => 'RecordController@like']);

    // unlike
    Route::post('/unlike',['uses' => 'RecordController@unlike']);

    // comment
    Route::post('/comment',['uses' => 'RecordController@comment']);

    // comment
    Route::get('/comments',['uses' => 'RecordController@commentIndex']);

    // comment
    Route::get('/comment',['uses' => 'RecordController@userReplies']);

    // unlike
    Route::delete('/comment/{id}',['uses' => 'RecordController@commentDelete']);

    // rating
    Route::post('/rating',['uses' => 'RecordController@rating']);

    Route::group(['prefix'  => 'bookmark'], function ($router){

        // показать все статьи
        Route::get('/',['uses' => 'RecordController@bookmark']);

        // показать все папки
        Route::get('/folder',['uses' => 'RecordController@bookmark_folder']);

        // создать папку
        Route::post('/store',['uses' => 'RecordController@bookmark_folder_store']);

        // обновить папку
        Route::post('/update',['uses' => 'RecordController@bookmark_folder_update']);

        // удалить папку
        Route::delete('/{id}',['uses' => 'RecordController@bookmark_folder_delete']);

        // добавить запись
        Route::post('/to_bookmark',['uses' => 'RecordController@to_bookmark']);

        // удалить запись из закладок
        Route::post('/delete',['uses' => 'RecordController@delete_bookmark']);

        // переместить запись
        Route::post('/move_record',['uses' => 'RecordController@from_bookmark']);

    });
});