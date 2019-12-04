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

    Route::get('addgalleryphoto', ['uses' => 'GalleryController@addGalleryPhoto', 'as' => 'addgalleryphoto']);
    Route::post('addgalleryphoto', ['uses' => 'GalleryController@addPhoto', 'as' => 'addPhoto']);
    Route::get('gallery/get/{id}', ['uses' => 'GalleryController@getPhoto', 'as' => 'getPhoto']);
    Route::get('photo/edit/{id}', ['uses' => 'GalleryController@addGalleryPhoto', 'as' => 'editPhoto']);
    Route::post('photo/edit/{id}', ['uses' => 'GalleryController@addPhoto', 'as' => 'postEditPhoto']);
    Route::get('photo/delete/{id}', ['uses' => 'GalleryController@getPhoto', 'as' => 'deletePhoto']);

});
