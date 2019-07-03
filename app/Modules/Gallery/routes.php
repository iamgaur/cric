<?php

/**
 * Routes are related to Dashboard page.
 */
Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Gallery\Controllers'], function() {
    Route::get('gallery', ['uses' => 'GalleryController@index', 'as' => 'gallery']);
    Route::get('add/gallery', ['uses' => 'GalleryController@add', 'as' => 'addGallery']);
    Route::post('add/gallery', ['uses' => 'GalleryController@save', 'as' => 'postAddGallery']);
    Route::get('edit/gallery/{id}', ['uses' => 'GalleryController@edit', 'as' => 'editGallery']);
    Route::post('edit/gallery/{id}', ['uses' => 'GalleryController@save', 'as' => 'postEditGallery']);
    Route::get('delete/gallery/{id}', ['uses' => 'GalleryController@delete', 'as' => 'deleteGallery']);
});