<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Country\Controllers'], function() {
    Route::get('countries', ['uses' => 'CountryController@index', 'as' => 'countries']);
    Route::get('add/country', ['uses' => 'CountryController@add', 'as' => 'addCountry']);
    Route::post('add/country', ['uses' => 'CountryController@save', 'as' => 'postAddCountry']);
    Route::get('edit/country/{name}/{id}', ['uses' => 'CountryController@edit', 'as' => 'editCountry']);
    Route::post('edit/country/{name}/{id}', ['uses' => 'CountryController@save', 'as' => 'postEditCountry']);
    Route::get('delete/country/{id}', ['uses' => 'CountryController@delete', 'as' => 'deleteCountry']);
});