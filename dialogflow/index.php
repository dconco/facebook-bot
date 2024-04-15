<?php

require 'vendor/autoload.php';

use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\SessionsClient;

// Set up Dialogflow session
$sessionsClient = new SessionsClient([
    'credentials' => '../project/daveconcoproject-defffea864a6.json'
]);
$session = $sessionsClient->sessionName('daveconcoproject', uniqid());

// User input
$userInput = 'Hello!';

// Send request to Dialogflow
$queryInput = new QueryInput();
$queryInput->setText(new TextInput([ 'text' => $userInput ]));
$response = $sessionsClient->detectIntent($session, $queryInput);

// Process Dialogflow response
$queryResult = $response->getQueryResult();
$fulfillmentText = $queryResult->getFulfillmentText();

echo $fulfillmentText;

// Close the SessionsClient
$sessionsClient->close();
