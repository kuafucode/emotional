<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('landing');
});

Route::get('/login', function()
{
    return View::make('login');
});

Route::get('/register', function()
{
    return View::make('register');
});

Route::controller('user', 'UserController');

Route::get('login', 'UserController@getLogin');
Route::post('postLogin', 'UserController@postLogin');
Route::post('logout',"UserController@getLogout");
Route::post('postRegister', 'UserController@postRegister');