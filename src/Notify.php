<?php

namespace DiscordHook;

use \GuzzleHttp\Client;

class Notify
{

   private $url = null;
   private $title = '';
   private $message = '';
   private $avatar = null;
   private $username = null;
   private $tts = false;
   private $embeds = [];
   private $client;
   private $modo = null;

   public function __construct(String $url = '',$modo = null)
   {
      return $this->_init($url,$modo);
   }

   private function _url(String $url = '',$modo = null )
   {
      return $this->_init($url,$modo);
   }

   private function _init(String $url,$modo = null)
   {
      $this->url = $url;
      $this->client = new Client([
         'base_uri' => $this->url
      ]);
      $this->modo = $modo;
      return $this;
   }

   public function message(String $message)
   {
      $this->message = $message;
      return $this;
   }
   public function title(String $title)
   {
      $this->title = $title;
      return $this;
   }

   public function embed(Embed $embed)
   {
      $this->embeds[] = $embed;
      return $this;
   }

   public function avatar(String $url){
      $this->avatar = $url;
      return $this;
   }

   public function username(String $url){
      $this->avatar = $url;
      return $this;
   }

   public function send()
   {
      try {

         if(!trim($this->url)){
            $this->messages[] = "Url do webhook é obrigatória";
            return false;
         }
         if(!filter_var($this->url,FILTER_VALIDATE_URL)){
            $this->messages[] = "Url do webhook é inválida";
            return false;
         }

         $options = [
            // Message
            "content" => $this->message,

            // Username
            "username" => $this->username,

            // Avatar URL.
            // Uncoment to replace image set in webhook
            "avatar_url" => $this->avatar,

            // Text-to-speech
            "tts" => $this->tts,

            // File upload
            // "file" => $this->attach,

            // Embeds Array
            "embeds" => $this->getEmbeds()

         ];

         if($this->modo == 'embed'){

            $embed = new Embed;
            $embed->title = $this->title;
            $embed->description = $this->message;

            $this->embed($embed);

            $options['content'] = '';
            $options['embeds'] = $this->getEmbeds();

         }

         $request = $this->client->request('POST', '', [
            'json' => $options
         ]);

         if($request->getStatusCode() == 204) return true;

         return false;

      } catch (\Exception $e) {
         return false;
      }
   }

   private function getEmbeds(){
      return array_map(function($e){
         return [
            'title' => $e->title,
            'type' => 'tich',
            'description' => $e->description
         ];
      },$this->embeds);
   }

   public function __call($metodo, $parametros)
   {
      if ($metodo == 'init') return (new static)->_init(...$parametros);
      if ($metodo == 'url') return (new static)->_url(...$parametros);

      return (new static)->$metodo(...$parametros);
   }

   public static function __callStatic($metodo, $parametros)
   {
      if ($metodo == 'init') return (new static)->_init(...$parametros);
      if ($metodo == 'url') return (new static)->_url(...$parametros);

      return (new static)->$metodo(...$parametros);
   }
}
