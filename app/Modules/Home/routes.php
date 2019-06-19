<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Route::group(['middleware' => 'web', 'namespace' => 'App\Modules\Home\Controllers'], function() {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
});