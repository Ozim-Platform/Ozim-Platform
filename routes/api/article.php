<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'article', 'middleware' => 'apiAuth'
],function ($router){

    // показать статьи
    Route::get('/',['uses' => 'ArticleController@index']);

    // Статьи по категории
    Route::get('/search-by-category/{category}/{id}',['uses' => 'ArticleController@search_by_category']);

    // поиск
    Route::get('/search',['uses' => 'ArticleController@search']);

    // показать записи из избранных
    Route::get('/index_bookmark',['uses' => 'ArticleController@bookmark']);

    // поставить лайк
    Route::post('/like',['uses' => 'ArticleController@like']);

    // убрать лайк
    Route::post('/unlike',['uses' => 'ArticleController@unlike']);

    // просмотр
    Route::post('/view',['uses' => 'ArticleController@view']);


    Route::group(['prefix'  => 'bookmark',
    ],function ($router){

        // показать все статьи
        Route::get('/',['uses' => 'ArticleController@bookmark']);

        // показать все папки
        Route::get('/folder',['uses' => 'ArticleController@bookmark_folder']);

        // создать папку
        Route::post('/store',['uses' => 'ArticleController@bookmark_folder_store']);

        // обновить папку
        Route::post('/update',['uses' => 'ArticleController@bookmark_folder_update']);

        // удалить папку
        Route::delete('/{id}',['uses' => 'ArticleController@bookmark_folder_delete']);

        // добавить запись
        Route::post('/store_article',['uses' => 'ArticleController@to_bookmark']);

        // удалить запись из закладок
        Route::post('/article',['uses' => 'ArticleController@delete_bookmark']);

        // переместить запись
        Route::post('/move_article',['uses' => 'ArticleController@from_bookmark']);

    });

        Route::group(['prefix'  => 'comment',
        ],function ($router) {

            // мои комменты
            Route::get('/',['uses' => 'ArticleController@commentIndex']);

            // создать коммент к статье / ответит
            Route::post('/store',['uses' => 'ArticleController@commentStore']);

            // удалить коммент
            Route::delete('/{id}',['uses' => 'ArticleController@commentDelete']);
        });

        // мои комменты
        Route::get('/comments',['uses' => 'ArticleController@commentsByArticleId']);
});
