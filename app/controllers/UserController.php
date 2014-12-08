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
        $oldUser = Sentry::getUser();
        $user = Sentry::getUser();

        $nameArray = explode(" ", Input::get('fullname'));
        $firstname = "";
        $lastname = "";
        for ($i=0; $i < count($nameArray) - 1; $i++ ) {
            $firstname .= $nameArray[$i];
        }
        if(count($nameArray) > 1) {
            $lastname = $nameArray[count($nameArray)-1];
        }
        $user->first_name = $firstname;
        $user->last_name = $lastname;
        $user->username = Input::get('username');
        if(Input::get('password') != null)
            $user->password = Input::get('password');
        $user->email = Input::get('email');
        $user->languages = Input::get('languageselector');

        try {
            $user->save();
            return View::make('profile');
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return View::make('profile')->withErrors(array('loginRequired' => "Email required"));
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return View::make('profile')->withErrors(array('passwordRequired' => "Password required"));
        }

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
            );
            $user = Sentry::register($credentials, true);

            if ($user) {
                return Redirect::to('user/register')->withInput()->with('success', 'User Created Successfully.');
            } else {
                return Redirect::to('user/register')->withInput()->with('fail', 'Registration failed.');
            }
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            $view = View::make('register')->withErrors(array('register' => "Email required"));
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $view = View::make('register')->withErrors(array('register' => "User exists"));
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            $view = View::make('register')->withErrors(array('register' => "Password required"));
        }
        catch(\Exception $e)
        {
            $view = View::make('register')->withErrors(array('register' => $e->getMessage()));
        }
        $this->layout->content = $view;

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

    public function postRemoveimage() {
        try {
            if($user = Sentry::getUser()) {

                if (Input::get('emotion') == "happy") {
                    if(file_exists('userimages/' . $user->id . $user->username . '_happy.png')) {
                        $fh = fopen('userimages/' . $user->id . $user->username . '_happy.png', 'a');
                        fclose($fh);
                        unlink('userimages/' . $user->id . $user->username . '_happy.png');
                    }
                    $user->positive_face = '';
                }
                if (Input::get('emotion') == "sad") {
                    if(file_exists('userimages/' . $user->id . $user->username . '_sad.png')) {
                        $fh = fopen('userimages/' . $user->id . $user->username . '_sad.png', 'a');
                        fclose($fh);
                        unlink('userimages/' . $user->id . $user->username . '_sad.png');
                    }
                    $user->negative_face = '';
                }
                if (Input::get('emotion') == "neutral") {
                    if(file_exists('userimages/' . $user->id . $user->username . '_neutral.png')) {
                        $fh = fopen('userimages/' . $user->id . $user->username . '_neutral.png', 'a');
                        fclose($fh);
                        unlink('userimages/' . $user->id . $user->username . '_neutral.png');
                    }
                    $user->neutral_face = '';
                }

                $user->save();
            } else {
                $this->layout->content = View::make('login');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return "Image removed successfully";
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
