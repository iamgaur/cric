<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Team\Controllers'], function() {
   Route::get('teams', ['as' => 'teams', 'uses' => 'TeamController@index']); 
   Route::get('add/team', ['as' => 'addTeam', 'uses' => 'TeamController@add']); 
   Route::post('add/team', ['as' => 'postAddTeam', 'uses' => 'TeamController@save']); 
   Route::get('edit/team', ['as' => 'editTeam', 'uses' => 'TeamController@edit']); 
   Route::post('edit/team', ['as' => 'postEditTeam', 'uses' => 'TeamController@save']); 
   Route::get('delete/team', ['as' => 'deleteTeam', 'uses' => 'TeamController@delete']); 
});