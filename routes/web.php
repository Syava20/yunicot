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
    Route::get('/active/{code}', 'Auth\RegisterController@active')->where(['code' => '[\s]{32}']);
    Route::get('/active', 'Auth\RegisterController@send');

    Route::get('/lang/{locale}', 'LocaleController@change')->where(['locale' => '(en|ru|ua)']);

    Route::get('/img/{id}/{filename}/{width}/{height?}/{type?}/{anchor?}', 'ImageController@whResize')->where(['id' => '[0-9]+']);
    Route::get('/img/{id}/{filename}/', 'ImageController@fullImage')->where(['id' => '[0-9]+']);
    Route::get('/img/photos/logos/{id}/{w?}/{x?}/{y?}', 'ImageController@showLogo')->where(['id' => '[0-9]+']);

    Route::group(['middleware' => 'auth'], function (){
        Route::get('/{id}', 'ProfileController@show')->where(['id' => '[0-9]+']);
        Route::get('/{id}/edit', 'ProfileController@edit')->where(['id' => '[0-9]+']);
    });
    Auth::routes();
});
