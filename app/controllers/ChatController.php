<?php
class ChatController extends BaseController {

    public function getIndex()
    {
        return View::make('chat');
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
