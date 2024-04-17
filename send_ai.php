<?php

use Orhanerday\OpenAi\OpenAi;

$open_ai = new OpenAi(getenv('OPEN_AI_SECRET'));
$open_ai->setOrg("org-vPGhQZnSjOOejGq7aUhjwYoB");

/**
 * SEND AI FUNCTION
 */
function send_ai(string $message)
{
   global $open_ai;

   try
   {
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
      if ($chat)
      {
         $data = json_decode($chat, false);

         if (!$data->error)
         {
            return $data->choices[0]->message->content;
         }

         return $data->error->message;
      }
      else
      {
         throw new Exception('Error while fetching Response!');
      }
   }
   catch ( Exception $e )
   {
      return "Uncaught Error: " . $e->getMessage();
   }
}