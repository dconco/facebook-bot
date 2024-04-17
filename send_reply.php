<?php

function send_reply(array $message): bool|array
{
   $access_token = getenv('FB_ACCESS_TOKEN');
   $url = "https://graph.facebook.com/v2.6/109664085466137/messages?access_token=$access_token";

   $options = [
      "http" => [
         "header" => "Content-type: application/json",
         "method" => "POST",
         "content" => json_encode($message),
      ],
   ];

   // get contents of response in API
   $context = stream_context_create($options);
   $resp = file_get_contents($url, false, $context);

   // change response value to null, and return null
   if ($resp)
   {
      return json_decode($resp, true) or true;
   }

   return false;
}