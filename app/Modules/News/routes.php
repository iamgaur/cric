<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\News\Controllers'], function() {
    Route::get('news', ['uses' => 'NewsController@index', 'as' => 'news']);
    Route::get('add/news', ['uses' => 'NewsController@add', 'as' => 'addNews']);
    Route::post('add/news', ['uses' => 'NewsController@save', 'as' => 'postaddNews']);
    Route::get('edit/news/{slug}', ['uses' => 'NewsController@edit', 'as' => 'editNews']);
    Route::post('edit/news/{slug}', ['uses' => 'NewsController@save', 'as' => 'posteditNews']);
    Route::get('delete/news/{slug}', ['uses' => 'NewsController@delete', 'as' => 'deleteNews']);
});