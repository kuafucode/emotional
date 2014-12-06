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
        $user = Auth::user();
        if($password = Input::get('password')) {
            $user->password = $password;
        }
        if($firstName = Input::get('first_name')) {
            $user->first_name = $firstName;
        }
        if($lastName = Input::get('last_name')) {
            $user->last_name = $lastName;
        }
        $user->save();
    }

    public function getRegister()
    {
        return View::make('register');
    }

    public function postRegister()
    {
        try
        {
            // Let's register a user.
            $user = Sentry::register(Input::all(), true);
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            echo 'Login field is required.';
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            echo 'Password field is required.';
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            echo 'User with this login already exists.';
        }
    }
}
