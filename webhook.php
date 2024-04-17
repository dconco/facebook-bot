<?php

include_once realpath(__DIR__ . '/config.php');
include_once realpath(__DIR__ . '/send_ai.php');

$challenge = $_GET['hub_challenge'];
$verify_token = $_GET['hub_verify_token'];
$my_verify_token = getenv('FB_VERIFY_TOKEN');

if ($my_verify_token === $verify_token) {
	exit($challenge);
}

$response = file_get_contents('php://input');

$response = json_decode($response, true);

/* Get Request Information */
$message = $response['entry'][0]['messaging'][0]['message']['text'];
$sender_id = $response['entry'][0]['messaging'][0]['sender']['id'];
$receiver_id = $response['entry'][0]['messaging'][0]['recipient']['id'];
$message_time = date(
	'd-m-Y H:i:s',
	$response['entry'][0]['messaging'][0]['timestamp']
);

$message1 = $message != null ? strtolower($message) : null;

if ($message1 === 'hi') {
	$new_message = 'Hey, am Spyrochat! How may we help you?';
} else {
	$new_message = send_ai($message);
}

if ($message != null) {
	$reply = [
		'messaging_type' => 'RESPONSE',
		'recipient' => [
			'id' => $sender_id,
		],
		'message' => [
			'text' => $new_message,
		],
	];
}

$response = send_reply($access_token, $reply);
$add_arr = [
	'message' => $new_message,
	'message_time' => $message_time,
];
