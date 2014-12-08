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

    public function getPredict()
    {
        $message = Input::get('message');
        $md5Key = 's-' . md5($message);
        if(1 || !Cache::has($md5Key)) {
            //set POST variables
            $url = 'https://community-sentiment.p.mashape.com/text/';
            $fields = array(
                'txt' => urlencode('this is good'),
            );

            //url-ify the data for the POST
            $fields_string = '';
            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');


            $ch = curl_init();

            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, 'txt=' . Input::get('message'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Mashape-Key: TKWkwvdWc2mshkVxXSYfRxbu2j1Ep1GnfLqjsnNP2jlznLAXLZ',
                'Content-Type: application/x-www-form-urlencoded'
            ));

            $result = curl_exec($ch);
            $result = str_replace("\n", '', $result);
            $result = json_decode($result);
            $user = Sentry::findUserById(Input::get('uuid'));
            $sentiment = 0;
            if($result->result->sentiment == 'Positive') {
                $sentiment = 1;
            }
            if($result->result->sentiment == 'Negative') {
                $sentiment = -1;
            }
            Cache::put('s-' . md5(Input::get('message')) , $sentiment, 10);

        }

        $sentiment = 0;
        if(Cache::has($md5Key)) {
            $sentiment = Cache::get($md5Key);
        }
        return Response::json( array('result' => $sentiment) );
    }
}
