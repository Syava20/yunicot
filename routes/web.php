<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::group(['middleware' => 'web'], function (){

    Route::get('/', 'HomeController@index');
    Route::get('/activation/{code}', 'Auth\RegisterController@activation');
    Route::get('/activation', 'Auth\RegisterController@sent');

    Route::get('/lang/{locale}', 'LocaleController@change')->where(['locale' => '(en|ru|ua)']);

    Route::get('/img/{id}/{filename}/{width}/{height?}/{x?}/{y?}/{nwidth?}', 'ImageController@whResize')
        ->where([
            'id' => '[0-9]+',
            'width' => '[0-9]+',
            'height' => '[0-9]+',
            'nwidth' => '[0-9]+',
            'x' => '[0-9]+',
            'y' => '[0-9]+'
    ]);
    Route::get('/img/{id}/{filename}/', 'ImageController@fullImage')->where(['id' => '[0-9]+']);
    Route::get('/img/photos/logos/{id}/{w?}/{x?}/{y?}', 'ImageController@showLogo')->where(['id' => '[0-9]+']);

    Route::group(['middleware' => 'auth'], function (){
        Route::get('/{id}', 'ProfileController@show')->where(['id' => '[0-9]+']);
        Route::get('/{id}/edit', 'ProfileController@edit')->where(['id' => '[0-9]+']);
        Route::post('/{id}/edit', 'ProfileController@store')->where(['id' => '[0-9]+']);
    });
    Auth::routes();


});