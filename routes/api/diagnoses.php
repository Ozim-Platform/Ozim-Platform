<?php
/*
|--------------------------------------------------------------------------
| Описание маршрутов
|--------------------------------------------------------------------------
|
| Содержит все маршруты
|
*/


Route::group(['prefix'  => 'diagnoses',
],function ($router){

    // показать диагнозы
    Route::get('/',['uses' => 'DiagnosisController@index']);


});