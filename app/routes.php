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

Route::get('/', 'HomeController@landing');

Route::controller('user', 'UserController');

Route::get('profile', function()
{
    return View::make('profile');
});

Route::controller('chat', 'ChatController');