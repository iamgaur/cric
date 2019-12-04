<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Player\Controllers'], function() {
    Route::get('players', ['uses' => 'PlayerController@index', 'as' => 'players']);
    Route::get('groupFields', ['uses' => 'PlayerController@groupFields', 'as' => 'groupFields']);
    Route::post('addGroupFields', ['uses' => 'PlayerController@addGroupFields', 'as' => 'addGroupFields']);
    Route::get('add/player', ['uses' => 'PlayerController@add', 'as' => 'addPlayer']);
    Route::post('add/player', ['uses' => 'PlayerController@save', 'as' => 'postAddPlayer']);
    Route::get('edit/player/{p_slug}/country/{c_slug}', ['uses' => 'PlayerController@edit', 'as' => 'editPlayer']);
    Route::post('edit/player/{p_slug}/country/{c_slug}', ['uses' => 'PlayerController@save', 'as' => 'postEditPlayer']);
    Route::get('delete/player/{id}', ['uses' => 'PlayerController@delete', 'as' => 'deletePlayer']);
});