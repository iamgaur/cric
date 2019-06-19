<?php

/* 
 * This file belongs to all login related routes.
 */

Route::group(['middleware' => ['web'], 'namespace' => 'App\Modules\Login\Controllers'],
    function() {
        Route::get('login', ['as' => 'login', 'uses' => 'LoginController@index']);
        Route::post('login', ['as' => 'postLogin', 'uses' => 'LoginController@postIndex']);
        Route::match(['get', 'post'], 'logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
});