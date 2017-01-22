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

Route::get('/', function () {
    return view('pages/home');
});

Route::get('/{account_type}/register','Auth\RegisterController@index');
Route::post('register', 'Auth\RegisterController@postRegister');

// Authentication routes...
Route::get('login', 'Auth\LoginController@getLogin');
Route::post('login', 'Auth\LoginController@postLogin');
Route::get('logout', 'Auth\LogoutController@getLogout');


Auth::routes();

Route::get('/home', 'HomeController@index');
