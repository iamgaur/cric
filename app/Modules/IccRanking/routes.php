<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\IccRanking\Controllers'], function() {
    Route::get('iccRankings', ['uses' => 'IccRankingController@index', 'as' => 'iccRanking']);
    Route::get('add/iccRanking', ['uses' => 'IccRankingController@add', 'as' => 'addIccRanking']);
    Route::post('add/iccRanking', ['uses' => 'IccRankingController@save', 'as' => 'postAddIccRanking']);
    Route::get('edit/iccRanking/{id}', ['uses' => 'IccRankingController@edit', 'as' => 'editIccRanking']);
    Route::post('edit/iccRanking/{id}', ['uses' => 'IccRankingController@save', 'as' => 'postEditIccRanking']);
    Route::get('delete/iccRanking/{id}', ['uses' => 'IccRankingController@delete', 'as' => 'deleteIccRanking']);
});