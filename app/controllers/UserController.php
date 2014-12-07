<?php

class UserController extends BaseController {
    protected $layout = "layouts.front";

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
        $view = '';

        $credentials = array(
            'email' => Input::get('email'),
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

                if ($user->positive_face == null &&
                    $user->negative_face == null &&
                    $user->neutral_face == null) {
                    return Redirect::to('user/profile');
                } else {
                    return Redirect::to('chat');
                }
            }
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            $view = View::make('login')->withErrors(array('login' => "Email required"));
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            $view = View::make('login')->withErrors(array('login' => "Password required"));
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            $view = View::make('login')->withErrors(array('login' => "Wrong password"));
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            $view = View::make('login')->withErrors(array('activation' => "User is not activated"));
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $view = View::make('login')->withErrors(array('usernotfound' => "User not found"));
        }
        catch(\Exception $e)
        {
            $view = View::make('login')->withErrors(array('login' => $e->getMessage()));
        }
        $this->layout->content = $view;
    }

    public function getLogin()
    {
        $this->layout->content = View::make('login');
    }

    public function postLogout()
    {
        Sentry::logout();
        return Redirect::to('/');
    }

    public function getProfile()
    {
        if (Sentry::check())
        {
            // profile editor
            $this->layout = null;
            return View::make('profile');
        }
        else
        {
            return Redirect::to('user/login');
        }

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
        $this->layout->content = View::make('register');
    }

    public function postRegister()
    {
        try
        {
            $credentials = array(
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'languages' => 'en',
            );
            $user = Sentry::register($credentials, true);

            if ($user) {
                return Redirect::to('user/register')->withInput()->with('success', 'Group Created Successfully.');
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

    public function postImage()
    {
        try {
            if($user = Sentry::getUser()) {

                if (Input::get('emotion') == "happy") {
                    file_put_contents('userimages/' . $user->id . $user->username . '_happy.png', base64_decode(Input::get('data')));
                    $user->positive_face = 'userimages/' . $user->id . $user->username . '_happy.png';
                }
                if (Input::get('emotion') == "sad") {
                    file_put_contents('userimages/' . $user->id . $user->username . '_sad.png', base64_decode(Input::get('data')));
                    $user->negative_face = 'userimages/' . $user->id . $user->username . '_sad.png';
                }
                if (Input::get('emotion') == "neutral") {
                    file_put_contents('userimages/' . $user->id . $user->username . '_neutral.png', base64_decode(Input::get('data')));
                    $user->neutral_face = 'userimages/' . $user->id . $user->username . '_neutral.png';
                }

                $user->save();
            } else {
                $this->layout->content = View::make('login');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return "Image saved successfully";
    }

    public function getFace() {
        $user = Sentry::getUser();
        $positive_img = "";
        $negative_img = "";
        $neutral_img = "";
        try {

            if ($user->positive_face != '')
                $positive_img = file_get_contents($user->positive_face);
            if ($user->negative_face != '')
                $negative_img = file_get_contents($user->negative_face);
            if ($user->neutral_face != '')
                $neutral_img = file_get_contents($user->neutral_face);

            $result = json_encode(array("positive_face" => base64_encode($positive_img),
                "negative_face" => base64_encode($negative_img),
                "neutral_face" => base64_encode($neutral_img)));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $result;
    }

    public function getSetting() {
        if (Sentry::check())
        {
            // profile editor
            $this->layout = null;
            return View::make('setting');
        }
        else
        {
            return Redirect::to('user/login');
        }
    }

    public function postSetting() {
        $language = Input::get("languageselector");
        $user = Sentry::getUser();
        $user->languages = $language;
        $user->save();

        return View::make('setting');
    }
}
