<?php

class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function postLogin()
	{
        //post login
	}

    public function getLogin()
    {
        return View::make('login');
    }

    public function getProfile()
    {
        // profile editor
    }

    public function postProfile()
    {
        //save profile
    }
}
