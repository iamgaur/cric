<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\MatchSquad\Controllers'], function() {
    Route::get('matchSquads', ['uses' => 'MatchSquadController@index', 'as' => 'matchSquads']);
    Route::get('edit/matchSquad/{slug}', ['uses' => 'MatchSquadController@edit', 'as' => 'editMatchSquad']);
    Route::post('edit/matchSquad/{slug}', ['uses' => 'MatchSquadController@save', 'as' => 'postEditMatchSquad']);
    Route::get('delete/matchSquad/{slug}', ['uses' => 'MatchSquadController@delete', 'as' => 'deleteMatchSquad']);
});