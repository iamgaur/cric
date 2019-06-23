<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Series\Controllers'], function() {
   Route::get('series', ['as' => 'series', 'uses' => 'SeriesController@index']); 
   Route::get('add/series', ['as' => 'addSeries', 'uses' => 'SeriesController@add']); 
   Route::post('add/series', ['as' => 'postAddSeries', 'uses' => 'SeriesController@save']); 
   Route::get('edit/series/{slug}', ['as' => 'editSeries', 'uses' => 'SeriesController@edit']); 
   Route::post('edit/series/{slug}', ['as' => 'postEditSeries', 'uses' => 'SeriesController@save']); 
   Route::get('delete/series/{slug}', ['as' => 'deleteSeries', 'uses' => 'SeriesController@delete']); 
});