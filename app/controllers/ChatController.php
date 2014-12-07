<?php
class ChatController extends BaseController {

    public function __construct() {
        $this->beforeFilter('auth');
    }

    public function getIndex()
    {
        return View::make('chat', array('user' => Sentry::getUser()));
    }

	public function postPresents()
	{
        $ids = Input::get('ids');
        foreach($ids as $id) {
            try
            {
                $user = Sentry::findUserById($id);
            }
            catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
            {
                continue;
            }
            $users[$id] = $user->fullname;
        }

        return Response::json( $users );
	}
}
