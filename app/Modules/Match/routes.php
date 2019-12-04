<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Match\Controllers'], function() {
    Route::get('matches', ['uses' => 'MatchController@index', 'as' => 'matches']);
    Route::get('add/match', ['uses' => 'MatchController@add', 'as' => 'addMatch']);
    Route::post('add/match', ['uses' => 'MatchController@save', 'as' => 'postAddMatch']);
    Route::get('edit/match/{slug}', ['uses' => 'MatchController@edit', 'as' => 'editMatch']);
    Route::post('edit/match/{slug}', ['uses' => 'MatchController@save', 'as' => 'postEditMatch']);
    Route::get('delete/match/{slug}', ['uses' => 'MatchController@delete', 'as' => 'deleteMatch']);
    Route::get('matchGroupFields', ['uses' => 'MatchController@groupFields', 'as' => 'matchGroupFields']);
    Route::post('matchAddGroupFields', ['uses' => 'MatchController@addGroupFields', 'as' => 'matchAddGroupFields']);
});