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
        $client = new Google_Client();
        $client->setApplicationName("Kuafu_Hackathon");
        $client->setDeveloperKey("AIzaSyCQJ4e5YNUJOeXZFZQKHOPMq9_jQmR_lys");

        $client->setAuthConfig('{"web":{"auth_uri":"https://accounts.google.com/o/oauth2/auth","client_secret":"PH9qz7NUZVbYa7vjBEnx20qs","token_uri":"https://accounts.google.com/o/oauth2/token","client_email":"844271735773-3mmlqth0qe6jsma8t2bfjiih65c7ku4f@developer.gserviceaccount.com","client_x509_cert_url":"https://www.googleapis.com/robot/v1/metadata/x509/844271735773-3mmlqth0qe6jsma8t2bfjiih65c7ku4f@developer.gserviceaccount.com","client_id":"844271735773-3mmlqth0qe6jsma8t2bfjiih65c7ku4f.apps.googleusercontent.com","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs"}}');

        $service = new Google_Service_Prediction($client);
        $input = new Google_Service_Prediction_Input();
        $inputinput = new Google_Service_Prediction_InputInput();
        $inputinput->setCsvInstance('test');
        $input->setInput($inputinput);
        $output = $service->hostedmodels->predict('projects/414649711441', 'sample.sentiment', $input);

        var_dump($output);exit();

    }
}
