<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;

class DialogflowController extends Controller
{
    public function handleUserInput($userInput)
    {
        $credentials = env('GOOGLE_APPLICATION_CREDENTIALS');
        $projectId = env('DIALOGFLOW_PROJECT_ID');
        $sessionClient = new SessionsClient(['credentials' => $credentials]);
        $session = $sessionClient->sessionName($projectId, 'unique-session-id');

        $textInput = new TextInput();
        $textInput->setText($userInput);
        $textInput->setLanguageCode('en-US');

        $queryInput = new QueryInput();
        $queryInput->setText($textInput);

        $response = $sessionClient->detectIntent($session, $queryInput);
        $result = $response->getQueryResult();

        $output = $result->getFulfillmentText();

        return $output;
    }
}
