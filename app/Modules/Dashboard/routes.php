<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'],'namespace' => 'App\Modules\Dashboard\Controllers'], function() {
    Route::get('dashboard', ['uses' => 'DashboardController@index', 'as' => 'dashboard']);
});