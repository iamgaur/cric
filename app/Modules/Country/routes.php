<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Country\Controllers'], function() {
    Route::get('countries', ['uses' => 'CountryController@index', 'as' => 'countries']);
    Route::get('addCountry', ['uses' => 'CountryController@add', 'as' => 'addCountry']);
    Route::post('addCountry', ['uses' => 'CountryController@save', 'as' => 'postAddCountry']);
    Route::get('editCountry/{name}/{id}', ['uses' => 'CountryController@edit', 'as' => 'editCountry']);
    Route::post('editCountry/{name}/{id}', ['uses' => 'CountryController@save', 'as' => 'postEditCountry']);
    Route::get('deleteCountry/{id}', ['uses' => 'CountryController@delete', 'as' => 'deleteCountry']);
});