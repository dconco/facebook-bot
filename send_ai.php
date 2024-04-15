<?php

include_once __DIR__ . "/config.php";
echo 'Hello';
use Orhanerday\OpenAi\OpenAi;

$open_ai = new OpenAi($open_ai_secret);
$open_ai->setORG("org-vPGhQZnSjOOejGq7aUhjwYoB");

/**
 * SEND AI FUNCTION
 */
function send_ai(string $message)
{
   try {
      global $open_ai;

      // send message
      $chat = $open_ai->chat([
         "model" => "gpt-3.5-turbo",
         "messages" => [
            [
               "role" => "user",
               "content" => $message,
            ],
         ],
         "temperature" => 1.0,
         "max_tokens" => 500,
         "frequency_penalty" => 0,
         "presence_penalty" => 0,
      ]);

      // send request back
      if ($chat) {
         $data = json_decode($chat);
         return $data->choices[0]->message->content;
      } else {
         throw new Error("Error while fetching Response!");
      }
   } catch (Exception $e) {
      return "Uncaught Error: " . $e->message;
   }
}

echo send_ai("Hello");