<?php

namespace App\Http;

class Request{
   /**
    * Gets the request method - [GET, POST, PUT, DELETE].
    * @return string The HTTP method.
    */
   public static function method():string{
      return $_SERVER['REQUEST_METHOD'];
   }

   /**
    * Gets the body of the request.
    * @return array The request's body.
    */
   public static function body():array{
      $method = self::method();

      if ($method === 'GET') return $_GET;

      $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
      if(str_contains($contentType, 'application/json')){
         $body = json_decode(file_get_contents('php://input'), true) ?? [];
         return is_array($body) ? $body : [];
      }

      return [];
   }

   /**
    * Gets the sent token.
    * @return array{error: string} if the token hasn't the correctly formart or doesn't be provided on failure.
    * @return array{token: string} the token on success.
    */
   public static function authorization():array{
      //Gets the corretly header regardelles of the server;
      $headers = array_change_key_case(getallheaders(), CASE_LOWER);

      if(!isset($headers['authorization'])) return ['error' => 'Not authorization header provided.'];
      
      $authorizationPartials = explode(' ', $headers['authorization']);

      if(count($authorizationPartials) !== 2 || strtolower($authorizationPartials[0]) !== 'bearer'){   
         return ['error' => 'Invalid Authorization header.'];
      } 

      return ['token' => $authorizationPartials[1]];
   }
}