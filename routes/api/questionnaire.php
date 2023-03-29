<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'questionnaire', 'middleware' => 'apiAuth'
],function ($router){

    // показать  анкеты
    Route::get('/',['uses' => 'QuestionnaireController@index']);

    // заполнить
    Route::post('/',['uses' => 'QuestionnaireController@answer']);

    // отправить по емейлу
    Route::post('/send',['uses' => 'QuestionnaireController@sendToEmailAnswer']);

});