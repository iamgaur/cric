<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\SeriesSquad\Controllers'], function() {
    Route::get('seriesSquads', ['uses' => 'SeriesSquadController@index', 'as' => 'seriesSquads']);
    Route::get('edit/seriesSquad/{slug}', ['uses' => 'SeriesSquadController@edit', 'as' => 'editSeriesSquad']);
    Route::post('edit/seriesSquad/{slug}', ['uses' => 'SeriesSquadController@save', 'as' => 'postEditSeriesSquad']);
    Route::get('delete/seriesSquad/{slug}', ['uses' => 'SeriesSquadController@delete', 'as' => 'deleteSeriesSquad']);
});