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

        $credentials = array(
            'email' => Input::get('user'),
            'password' => Input::get('pwd'),
        );

        try
        {
            $user = Sentry::authenticate($credentials, false);
            if ($user)
            {
                if(Input::get('remember')=='true')
                    Sentry::loginAndRemember($user);
                else
                    Sentry::login($user);
                return View::make('landing');
            }
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return View::make('login')->withErrors(array('login' => "Email required"));
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return View::make('login')->withErrors(array('login' => "Password required"));
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            return View::make('login')->withErrors(array('login' => "Wrong password"));
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            return View::make('login')->withErrors(array('activation' => "User is not activated"));
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return View::make('login')->withErrors(array('usernotfound' => "User not found"));
        }
        catch(\Exception $e)
        {
            return View::make('login')->withErrors(array('login' => $e->getMessage()));
        }


    }

    public function getLogin()
    {
        return View::make('login');
    }

    public function postLogout()
    {
        Sentry::logout();
        return Redirect::to('/');
    }

    public function getProfile()
    {
        // profile editor
    }

    public function postProfile()
    {
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

        return View::make('profile');
    }

    public function getRegister()
    {
        return View::make('register');
    }

    public function postRegister()
    {
        try
        {
            $credentials = array(
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            );
            $user = Sentry::register($credentials, true);

            if ($user) {
                return Redirect::to('register')->withInput()->with('success', 'Group Created Successfully.');
            } else {
                echo 'User not found<br/>';
            }
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            echo 'Login field is required.<br/>'.$e->getMessage();
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            echo 'Password field is required.<br/>'.$e->getMessage();
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            echo 'User with this login already exists.<br/>'.$e->getMessage();
        }
    }
}
