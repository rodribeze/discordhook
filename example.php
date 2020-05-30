<?php

   require 'vendor/autoload.php';

   use \DiscordHook\Notify;

   $urlWebHook = '';

   Notify::send($urlWebHook,[
      'message' => 'Teste'
   ]);