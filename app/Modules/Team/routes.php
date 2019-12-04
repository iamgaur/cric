<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Team\Controllers'], function() {
   Route::get('teams', ['as' => 'teams', 'uses' => 'TeamController@index']);
   Route::get('add/team', ['as' => 'addTeam', 'uses' => 'TeamController@add']);
   Route::post('add/team', ['as' => 'postAddTeam', 'uses' => 'TeamController@save']);
   Route::get('add/type', ['as' => 'getType', 'uses' => 'TeamController@teamType']);
   Route::post('add/type', ['as' => 'addType', 'uses' => 'TeamController@saveTeamType']);
   Route::get('edit/team/{slug}', ['as' => 'editTeam', 'uses' => 'TeamController@edit']);
   Route::post('edit/team/{slug}', ['as' => 'postEditTeam', 'uses' => 'TeamController@save']);
   Route::get('delete/team/{slug}', ['as' => 'deleteTeam', 'uses' => 'TeamController@delete']);
});
