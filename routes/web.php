<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($router){

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'category', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'CategoryController@index')->name('admin.category.index');
        Route::get('/create', 'CategoryController@create')->name('admin.category.create');
        Route::post('/', 'CategoryController@store')->name('admin.category.store');
        Route::get('/edit/{item}', 'CategoryController@edit')->name('admin.category.edit');
        Route::post('/update/{item}', 'CategoryController@update')->name('admin.category.update');
        Route::delete('/destroy/{item}', 'CategoryController@destroy')->name('admin.category.destroy');

    });

    Route::group(['prefix' => 'language', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'LanguageController@index')->name('admin.language.index');
        Route::get('/create', 'LanguageController@create')->name('admin.language.create');
        Route::post('/', 'LanguageController@store')->name('admin.language.store');
        Route::get('/edit/{item}', 'LanguageController@edit')->name('admin.language.edit');
        Route::post('/update/{item}', 'LanguageController@update')->name('admin.language.update');
        Route::delete('/destroy/{item}', 'LanguageController@destroy')->name('admin.language.destroy');

    });

    Route::group(['prefix' => 'article', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'ArticleController@index')->name('admin.article.index');
        Route::get('/create', 'ArticleController@create')->name('admin.article.create');
        Route::post('/', 'ArticleController@store')->name('admin.article.store');
        Route::get('/edit/{item}', 'ArticleController@edit')->name('admin.article.edit');
        Route::post('/update/{item}', 'ArticleController@update')->name('admin.article.update');
        Route::delete('/destroy/{item}', 'ArticleController@destroy')->name('admin.article.destroy');

    });

    Route::group(['prefix' => 'diagnosis', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'DiagnosisController@index')->name('admin.diagnosis.index');
        Route::get('/create', 'DiagnosisController@create')->name('admin.diagnosis.create');
        Route::post('/', 'DiagnosisController@store')->name('admin.diagnosis.store');
        Route::get('/edit/{item}', 'DiagnosisController@edit')->name('admin.diagnosis.edit');
        Route::post('/update/{item}', 'DiagnosisController@update')->name('admin.diagnosis.update');
        Route::delete('/destroy/{item}', 'DiagnosisController@destroy')->name('admin.diagnosis.destroy');

    });

    Route::group(['prefix' => 'faq', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'FaqController@index')->name('admin.faq.index');
        Route::get('/create', 'FaqController@create')->name('admin.faq.create');
        Route::post('/', 'FaqController@store')->name('admin.faq.store');
        Route::get('/edit/{item}', 'FaqController@edit')->name('admin.faq.edit');
        Route::post('/update/{item}', 'FaqController@update')->name('admin.faq.update');
        Route::delete('/destroy/{item}', 'FaqController@destroy')->name('admin.faq.destroy');

    });

    Route::group(['prefix' => 'forum', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'ForumController@index')->name('admin.forum.index');
        Route::get('/create', 'ForumController@create')->name('admin.forum.create');
        Route::post('/', 'ForumController@store')->name('admin.forum.store');
        Route::get('/edit/{item}', 'ForumController@edit')->name('admin.forum.edit');
        Route::post('/update/{item}', 'ForumController@update')->name('admin.forum.update');
        Route::delete('/destroy/{item}', 'ForumController@destroy')->name('admin.forum.destroy');

    });

    Route::group(['prefix' => 'forum_category', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'ForumCategoryController@index')->name('admin.forum_category.index');
        Route::get('/create', 'ForumCategoryController@create')->name('admin.forum_category.create');
        Route::post('/', 'ForumCategoryController@store')->name('admin.forum_category.store');
        Route::get('/edit/{item}', 'ForumCategoryController@edit')->name('admin.forum_category.edit');
        Route::post('/update/{item}', 'ForumCategoryController@update')->name('admin.forum_category.update');
        Route::delete('/destroy/{item}', 'ForumCategoryController@destroy')->name('admin.forum_category.destroy');

    });

    Route::group(['prefix' => 'forum_subcategory', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'ForumSubcategoryController@index')->name('admin.forum_subcategory.index');
        Route::get('/create', 'ForumSubcategoryController@create')->name('admin.forum_subcategory.create');
        Route::post('/', 'ForumSubcategoryController@store')->name('admin.forum_subcategory.store');
        Route::get('/edit/{item}', 'ForumSubcategoryController@edit')->name('admin.forum_subcategory.edit');
        Route::post('/update/{item}', 'ForumSubcategoryController@update')->name('admin.forum_subcategory.update');
        Route::delete('/destroy/{item}', 'ForumSubcategoryController@destroy')->name('admin.forum_subcategory.destroy');

    });

    Route::group(['prefix' => 'link', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'LinkController@index')->name('admin.link.index');
        Route::get('/create', 'LinkController@create')->name('admin.link.create');
        Route::post('/', 'LinkController@store')->name('admin.link.store');
        Route::get('/edit/{item}', 'LinkController@edit')->name('admin.link.edit');
        Route::post('/update/{item}', 'LinkController@update')->name('admin.link.update');
        Route::delete('/destroy/{item}', 'LinkController@destroy')->name('admin.link.destroy');

    });

    Route::group(['prefix' => 'inclusion', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'InclusionController@index')->name('admin.inclusion.index');
        Route::get('/create', 'InclusionController@create')->name('admin.inclusion.create');
        Route::post('/', 'InclusionController@store')->name('admin.inclusion.store');
        Route::get('/edit/{item}', 'InclusionController@edit')->name('admin.inclusion.edit');
        Route::post('/update/{item}', 'InclusionController@update')->name('admin.inclusion.update');
        Route::delete('/destroy/{item}', 'InclusionController@destroy')->name('admin.inclusion.destroy');

    });

    Route::group(['prefix' => 'rights', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'RightsController@index')->name('admin.rights.index');
        Route::get('/create', 'RightsController@create')->name('admin.rights.create');
        Route::post('/', 'RightsController@store')->name('admin.rights.store');
        Route::get('/edit/{item}', 'RightsController@edit')->name('admin.rights.edit');
        Route::post('/update/{item}', 'RightsController@update')->name('admin.rights.update');
        Route::delete('/destroy/{item}', 'RightsController@destroy')->name('admin.rights.destroy');

    });

    Route::group(['prefix' => 'service_provider', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'ServiceProviderController@index')->name('admin.service_provider.index');
        Route::get('/create', 'ServiceProviderController@create')->name('admin.service_provider.create');
        Route::post('/', 'ServiceProviderController@store')->name('admin.service_provider.store');
        Route::get('/edit/{item}', 'ServiceProviderController@edit')->name('admin.service_provider.edit');
        Route::post('/update/{item}', 'ServiceProviderController@update')->name('admin.service_provider.update');
        Route::delete('/destroy/{item}', 'ServiceProviderController@destroy')->name('admin.service_provider.destroy');

    });

    Route::group(['prefix' => 'skill', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'SkillController@index')->name('admin.skill.index');
        Route::get('/create', 'SkillController@create')->name('admin.skill.create');
        Route::post('/', 'SkillController@store')->name('admin.skill.store');
        Route::get('/edit/{item}', 'SkillController@edit')->name('admin.skill.edit');
        Route::post('/update/{item}', 'SkillController@update')->name('admin.skill.update');
        Route::delete('/destroy/{item}', 'SkillController@destroy')->name('admin.skill.destroy');

    });

    Route::group(['prefix' => 'users', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'UserController@index')->name('admin.users.index');
        Route::get('/create', 'UserController@create')->name('admin.users.create');
        Route::post('/', 'UserController@store')->name('admin.users.store');
        Route::get('/edit/{item}', 'UserController@edit')->name('admin.users.edit');
        Route::post('/update/{item}', 'UserController@update')->name('admin.users.update');
        Route::delete('/destroy/{item}', 'UserController@destroy')->name('admin.users.destroy');

    });

    Route::group(['prefix' => 'questionnaire', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'QuestionnaireController@index')->name('admin.questionnaire.index');
        Route::get('/select', 'QuestionnaireController@select')->name('admin.questionnaire.select');
        Route::get('/create', 'QuestionnaireController@create')->name('admin.questionnaire.create');
        Route::post('/', 'QuestionnaireController@store')->name('admin.questionnaire.store');
        Route::get('/edit/{item}', 'QuestionnaireController@edit')->name('admin.questionnaire.edit');
        Route::post('/update/{item}', 'QuestionnaireController@update')->name('admin.questionnaire.update');
        Route::delete('/destroy/{item}', 'QuestionnaireController@destroy')->name('admin.questionnaire.destroy');

    });

    Route::group(['prefix' => 'questionnaire_answer', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'QuestionnaireAnswerController@index')->name('admin.questionnaire_answer.index');
        Route::get('/create', 'QuestionnaireAnswerController@create')->name('admin.questionnaire_answer.create');
        Route::post('/', 'QuestionnaireAnswerController@store')->name('admin.questionnaire_answer.store');
        Route::get('/edit/{item}', 'QuestionnaireAnswerController@edit')->name('admin.questionnaire_answer.edit');
        Route::post('/update/{item}', 'QuestionnaireAnswerController@update')->name('admin.questionnaire_answer.update');
        Route::delete('/destroy/{item}', 'QuestionnaireAnswerController@destroy')->name('admin.questionnaire_answer.destroy');

    });

    Route::group(['prefix' => 'for_parent', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'ForParentController@index')->name('admin.for_parent.index');
        Route::get('/create', 'ForParentController@create')->name('admin.for_parent.create');
        Route::post('/', 'ForParentController@store')->name('admin.for_parent.store');
        Route::get('/edit/{item}', 'ForParentController@edit')->name('admin.for_parent.edit');
        Route::post('/update/{item}', 'ForParentController@update')->name('admin.for_parent.update');
        Route::delete('/destroy/{item}', 'ForParentController@destroy')->name('admin.for_parent.destroy');

    });

    Route::group(['prefix' => 'banner', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'BannerController@index')->name('admin.banner.index');
        Route::get('/create', 'BannerController@create')->name('admin.banner.create');
        Route::post('/', 'BannerController@store')->name('admin.banner.store');
        Route::get('/edit/{item}', 'BannerController@edit')->name('admin.banner.edit');
        Route::post('/update/{item}', 'BannerController@update')->name('admin.banner.update');
        Route::delete('/destroy/{item}', 'BannerController@destroy')->name('admin.banner.destroy');
        Route::get('/records_by_type', 'BannerController@getRecordsByType')->name('admin.banner.get_records_by_type');
    });

    Route::group(['prefix' => 'video', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'VideoController@index')->name('admin.video.index');
        Route::get('/create', 'VideoController@create')->name('admin.video.create');
        Route::post('/', 'VideoController@store')->name('admin.video.store');
        Route::get('/edit/{item}', 'VideoController@edit')->name('admin.video.edit');
        Route::post('/update/{item}', 'VideoController@update')->name('admin.video.update');
        Route::delete('/destroy/{item}', 'VideoController@destroy')->name('admin.video.destroy');

    });

    Route::group(['prefix' => 'partner', 'middleware' => 'auth'], function ($router) {

        Route::get('/', 'PartnerController@index')->name('admin.partner.index');
        Route::get('/create', 'PartnerController@create')->name('admin.partner.create');
        Route::post('/', 'PartnerController@store')->name('admin.partner.store');
        Route::get('/edit/{item}', 'PartnerController@edit')->name('admin.partner.edit');
        Route::post('/update/{item}', 'PartnerController@update')->name('admin.partner.update');
        Route::delete('/destroy/{item}', 'PartnerController@destroy')->name('admin.partner.destroy');

    });
});

Route::get('/download-mobile', function () {
    return view('/download-mobile', []);
})->name('download-mobile');

Route::group(['prefix' => 'ul'], function ($router) {
    Route::any('{any}', function () {
        return redirect('download-mobile');
    });
});

Route::get('/apple-app-site-association', function ()
{
    $path = public_path('apple-app-site-association.json');
    $content = json_decode(file_get_contents($path));

    return response()->json($content);
});

