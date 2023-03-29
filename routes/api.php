<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api', 'middleware' => 'throttle:200,1'
],function ($router){

    // маршруты пользователей
    require base_path('routes/api/user/user.php');

    // маршруты firebase token
    require base_path('routes/api/user/token.php');

    // маршруты языка
    require base_path('routes/api/language/language.php');

    // маршруты категории
    require base_path('routes/api/category/category.php');

    // маршруты типов пользователей
    require base_path('routes/api/user_type/user_type.php');

    // маршруты статьей
    require base_path('routes/api/article.php');

    // маршруты faq
    require base_path('routes/api/faq.php');

    // маршруты форума
    require base_path('routes/api/forum/forum.php');
    require base_path('routes/api/forum/forum_category.php');
    require base_path('routes/api/forum/forum_subcategory.php');

    // маршруты ссылки
    require base_path('routes/api/link.php');

    // маршруты анкета
    require base_path('routes/api/questionnaire.php');

    // маршруты диагнозов
    require base_path('routes/api/diagnoses.php');

    // маршруты навыки
    require base_path('routes/api/skill.php');

    // маршруты услугодатели
    require base_path('routes/api/service_provider.php');

    // маршруты права
    require base_path('routes/api/rights.php');

    // маршруты инклюзии
    require base_path('routes/api/inclusion.php');

    // маршруты для мамы
    require base_path('routes/api/for_parent.php');

    // маршруты для просмотра лайка записей кроме статьей
    require base_path('routes/api/record.php');

    // маршруты filter
    require base_path('routes/api/filter.php');

    // маршруты баннеров
    require base_path('routes/api/banner.php');

    // маршруты
    require base_path('routes/api/chat_push.php');

    // маршруты для video
    require base_path('routes/api/video.php');

    // маршруты для partner
    require base_path('routes/api/partner.php');

});
