<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\MatchTeams\Controllers'], function() {
    Route::get('matchTeams', ['uses' => 'MatchTeamsController@index', 'as' => 'matchTeams']);
    Route::get('add/matchTeams', ['uses' => 'MatchTeamsController@add', 'as' => 'addMatchTeams']);
    Route::post('add/matchTeams', ['uses' => 'MatchTeamsController@save', 'as' => 'postaddMatchTeams']);
    Route::get('edit/matchTeams/{id}', ['uses' => 'MatchTeamsController@edit', 'as' => 'editMatchTeams']);
    Route::post('edit/matchTeams/{id}', ['uses' => 'MatchTeamsController@save', 'as' => 'posteditMatchTeams']);
    Route::get('delete/matchTeams/{id}', ['uses' => 'MatchTeamsController@delete', 'as' => 'deleteMatchTeams']);
});