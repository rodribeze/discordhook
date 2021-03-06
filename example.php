<?php

require 'vendor/autoload.php';

use \DiscordHook\Notify;

$urlWebHook = 'https://discordapp.com/api/webhooks/711577169616175184/pwMbdqZ1xIQu_51y-tJmARQDH-eN9wxy6d_tzOsud1HNgUAKPCWMuFelA61FXjk4OhUH';
$url_avatar = "https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png";

# Notificação simples
$notify = Notify::url($urlWebHook)
   ->message("teste simples")
   ->avatar($url_avatar)
   ->send();

# Modo embed
$notify = Notify::url($urlWebHook,'embed')
   ->title("teste title")
   ->message("teste embed")
   ->avatar($url_avatar)
   ->send();

# Usando varios embeds
$embed = new \DiscordHook\Embed;
$embed->title = 'embed 1';
$embed->description = "Teste multi embeds 1";

$embed2 = new \DiscordHook\Embed;
$embed2->title = 'embed 2';
$embed2->description = "Teste multi embeds 2";

$notify = Notify::url($urlWebHook)
   ->avatar($url_avatar)
   ->embed($embed)
   ->embed($embed2)
   ->send();
